<template>
    <div class="folder-tree">
        <template v-for="node in nodes" :key="node.id">
            <div
                class="folder-node d-flex align-center"
                :class="{
                    'folder-selected': node.id === selectedId,
                    'folder-disabled': node.id === disabledId,
                }"
                :style="{ paddingLeft: (depth * 16 + 4) + 'px' }"
                @click="onSelect(node)"
            >
                <v-icon
                    size="18"
                    class="mr-1 toggle-icon"
                    @click.stop="onToggle(node)"
                >
                    {{ hasChildren(node) ? (isOpen(node.id) ? 'mdi-menu-down' : 'mdi-menu-right') : '' }}
                </v-icon>
                <v-icon size="18" color="amber-darken-2" class="mr-1">mdi-folder</v-icon>
                <span class="folder-name text-truncate">{{ node.name }}</span>
                <span v-if="node.files_count" class="text-caption text-grey ml-1">{{ node.files_count }}</span>
            </div>

            <folder-tree
                v-if="hasChildren(node) && isOpen(node.id)"
                :nodes="node.children"
                :selected-id="selectedId"
                :disabled-id="disabledId"
                :depth="depth + 1"
                :open-ids="openIds"
                @select="$emit('select', $event)"
                @toggle="$emit('toggle', $event)"
            ></folder-tree>
        </template>
    </div>
</template>

<script setup>
const props = defineProps({
    nodes: { type: Array, default: () => [] },
    selectedId: { default: null },
    disabledId: { default: null },
    depth: { type: Number, default: 0 },
    openIds: { type: Array, default: () => [] },
});

const emit = defineEmits(['select', 'toggle']);

const hasChildren = (node) => Array.isArray(node.children) && node.children.length > 0;
const isOpen = (id) => props.openIds.includes(id);

const onSelect = (node) => {
    if (node.id === props.disabledId) return;
    emit('select', node);
};

const onToggle = (node) => {
    if (hasChildren(node)) emit('toggle', node.id);
};
</script>

<style scoped>
.folder-node {
    cursor: pointer;
    border-radius: 4px;
    padding-top: 4px;
    padding-bottom: 4px;
}
.folder-node:hover {
    background: rgba(0, 0, 0, 0.04);
}
.folder-selected {
    background: rgba(255, 87, 34, 0.12);
}
.folder-disabled {
    opacity: 0.4;
    pointer-events: none;
}
.folder-name {
    font-size: 0.875rem;
    max-width: 160px;
}
.toggle-icon {
    width: 18px;
}
</style>
