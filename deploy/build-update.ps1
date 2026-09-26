<#
.SYNOPSIS
    Build update bundles for the cPanel server (techno-triireka.co.id).

.DESCRIPTION
    Writes small archives OUTSIDE the repo, to ..\techno-deploy-zips\update-<stamp>\ :

      public -> update_public.zip  extract into /home/techno/public_html
                                   (build/, plus images/ with -WithImages)
      app    -> update_app.zip     extract into /home/techno/laravel_app
                                   (app, routes, config, resources/views, bootstrap/app.php + providers.php)
      vendor -> vendor.zip         delete /home/techno/laravel_app/vendor first, then extract into
                                   /home/techno/laravel_app (vendor + regenerated bootstrap/cache/packages.php)

    Never bundled: .env, storage/, public/index.php, public/.htaccess (the server has its own).
    composer --no-dev runs in a temp copy, so the local vendor/ is left untouched.

    Runbook: docs/DEPLOY-CPANEL.md. Skill: .claude/skills/deploy-update/SKILL.md

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File deploy\build-update.ps1 -Target public,app
#>
[CmdletBinding()]
param(
    [string[]]$Target = @('public', 'app'),

    # Reuse the existing public/build instead of running npm run build
    [switch]$SkipBuild,

    # Also bundle public/images (only when static images changed)
    [switch]$WithImages
)

$ErrorActionPreference = 'Stop'

# With "powershell -File", "-Target public,app" arrives as ONE string, so split and validate by hand
$Target = @($Target | ForEach-Object { $_ -split ',' } | ForEach-Object { $_.Trim() } | Where-Object { $_ })
foreach ($t in $Target) {
    if ($t -notin 'public', 'app', 'vendor') { throw "Target tidak dikenal: '$t' (pilih: public, app, vendor)" }
}

$repo   = Split-Path -Parent $PSScriptRoot
$stamp  = Get-Date -Format 'yyyyMMdd-HHmm'
$outDir = Join-Path (Split-Path -Parent $repo) "techno-deploy-zips\update-$stamp"
$work   = Join-Path $env:TEMP "techno-update-$stamp"

function New-Stage([string]$name) {
    $path = Join-Path $work $name
    New-Item -ItemType Directory -Path $path -Force | Out-Null
    return $path
}

function Copy-Tree([string]$from, [string]$to) {
    New-Item -ItemType Directory -Path (Split-Path -Parent $to) -Force | Out-Null
    Copy-Item -Path $from -Destination $to -Recurse -Force
}

function Write-Zip([string]$stage, [string]$name) {
    $zip = Join-Path $outDir $name
    Compress-Archive -Path (Join-Path $stage '*') -DestinationPath $zip -Force
    $files = (Get-ChildItem $stage -Recurse -File).Count
    $mb = [math]::Round((Get-Item $zip).Length / 1MB, 1)
    Write-Host ("  {0}  ({1} file, {2} MB)" -f $zip, $files, $mb)
}

New-Item -ItemType Directory -Path $outDir -Force | Out-Null

try {
    if ($Target -contains 'public') {
        Write-Host '[public] frontend'

        if (-not $SkipBuild) {
            Push-Location $repo
            try {
                npm run build
                if ($LASTEXITCODE -ne 0) { throw 'npm run build gagal' }
            } finally {
                Pop-Location
            }
        }

        $manifestFile = Join-Path $repo 'public\build\manifest.json'
        if (-not (Test-Path $manifestFile)) {
            throw 'public/build/manifest.json tidak ada. Jalankan tanpa -SkipBuild.'
        }

        # resources/views/app.blade.php reads these entries when APP_ENV=production
        $manifest = Get-Content $manifestFile -Raw | ConvertFrom-Json
        foreach ($key in 'resources/css/app.css', 'resources/js/app.js') {
            if (-not $manifest.PSObject.Properties[$key]) {
                throw "manifest.json tidak punya entry '$key'"
            }
        }
        foreach ($css in $manifest.'resources/js/app.js'.css) {
            if (-not (Test-Path (Join-Path $repo "public\build\$css"))) {
                throw "CSS '$css' ada di manifest tapi filenya tidak ada"
            }
        }

        $stage = New-Stage 'public'
        Copy-Tree (Join-Path $repo 'public\build') (Join-Path $stage 'build')
        if ($WithImages) {
            Copy-Tree (Join-Path $repo 'public\images') (Join-Path $stage 'images')
        }
        Write-Zip $stage 'update_public.zip'
    }

    if ($Target -contains 'app') {
        Write-Host '[app] backend'

        $stage = New-Stage 'app'
        foreach ($dir in 'app', 'routes', 'config') {
            Copy-Tree (Join-Path $repo $dir) (Join-Path $stage $dir)
        }
        Copy-Tree (Join-Path $repo 'resources\views') (Join-Path $stage 'resources\views')
        foreach ($file in 'app.php', 'providers.php') {
            Copy-Tree (Join-Path $repo "bootstrap\$file") (Join-Path $stage "bootstrap\$file")
        }
        Write-Zip $stage 'update_app.zip'
    }

    if ($Target -contains 'vendor') {
        Write-Host '[vendor] composer install --no-dev (di salinan sementara, bukan di repo)'

        $stage = New-Stage 'vendor'
        foreach ($dir in 'app', 'bootstrap', 'config', 'routes') {
            Copy-Tree (Join-Path $repo $dir) (Join-Path $stage $dir)
        }
        foreach ($file in 'artisan', 'composer.json', 'composer.lock') {
            Copy-Item (Join-Path $repo $file) (Join-Path $stage $file)
        }
        foreach ($dir in 'storage\framework\cache\data', 'storage\framework\sessions', 'storage\framework\views', 'storage\logs') {
            New-Item -ItemType Directory -Path (Join-Path $stage $dir) -Force | Out-Null
        }
        # Local compiled manifests list dev-only packages; let composer regenerate them
        Get-ChildItem (Join-Path $stage 'bootstrap\cache') -Filter *.php -ErrorAction SilentlyContinue |
            Remove-Item -Force

        Push-Location $stage
        try {
            composer install --no-dev --optimize-autoloader --no-interaction
            if ($LASTEXITCODE -ne 0) { throw 'composer install gagal' }
        } finally {
            Pop-Location
        }

        # Bundle only vendor + the regenerated compiled manifests (not the rest of the staging copy)
        $bundle = New-Stage 'vendor-bundle'
        Move-Item (Join-Path $stage 'vendor') (Join-Path $bundle 'vendor')
        New-Item -ItemType Directory -Path (Join-Path $bundle 'bootstrap\cache') -Force | Out-Null
        Get-ChildItem (Join-Path $stage 'bootstrap\cache') -Filter *.php |
            Copy-Item -Destination (Join-Path $bundle 'bootstrap\cache')
        Write-Zip $bundle 'vendor.zip'
    }

    Write-Host ''
    Write-Host "Selesai. Output: $outDir"
    Write-Host ''
    Write-Host 'Upload + Extract di File Manager cPanel:'
    if ($Target -contains 'public') { Write-Host '  update_public.zip -> /home/techno/public_html   (Extract di situ, timpa build/ lama)' }
    if ($Target -contains 'app')    { Write-Host '  update_app.zip    -> /home/techno/laravel_app   (Extract di situ, timpa file lama)' }
    if ($Target -contains 'vendor') { Write-Host '  vendor.zip        -> /home/techno/laravel_app   (HAPUS folder vendor lama dulu, baru Extract)' }
} finally {
    Remove-Item $work -Recurse -Force -ErrorAction SilentlyContinue
}
