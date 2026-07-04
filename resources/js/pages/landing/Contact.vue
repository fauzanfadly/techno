<template>
    <landing-page-layout id="pages-landing-contact">
        <div id="components-landingpage-contact">
            <!-- Hero Section -->
            <v-container fluid class="pa-0">
                <v-sheet height="60vh" class="background-image blueprint-grid position-relative">
                    <div class="overlay"></div>
                    <v-row
                        class="fill-height pt-15"
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12" md="8" lg="6" class="text-white-container text-center px-4">
                            <p class="section-eyebrow mb-4">Hubungi Kami</p>
                            <p class="text-white text-h2 text-uppercase font-weight-bold mb-4">
                                Contact Us
                            </p>
                            <p class="text-white text-body-1 mx-auto" style="max-width: 600px; line-height: 1.7;">
                                Tim profesional kami siap membantu Anda. Hubungi kami untuk konsultasi, penawaran harga, atau pertanyaan lainnya.
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>

            <!-- Contact Content -->
            <v-container class="py-16 pb-15">
                <!-- Section Header -->
                <div class="text-center mb-12" data-aos="fade-up">
                    <p class="section-eyebrow">Informasi Kontak</p>
                    <h2 class="text-h3 font-weight-bold text-primary mb-4">Hubungi Kami</h2>
                    <div class="heading-accent mx-auto"></div>
                </div>

                <v-row>
                    <!-- Contact Cards Column -->
                    <v-col cols="12" md="5">
                        <!-- Phone Card -->
                        <v-card
                            class="card-elevated mb-4"
                            rounded="lg"
                            data-aos="fade-up"
                            data-aos-delay="100"
                        >
                            <v-container>
                                <v-row class="align-center py-4">
                                    <v-col sm="auto" md="auto">
                                        <div class="contact-icon-wrapper">
                                            <v-icon size="28" color="white">mdi-phone</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-caption text-grey mb-1">Telepon</p>
                                        <p class="text-h6 font-weight-bold text-primary">+62 (021) 8887 6969</p>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>

                        <!-- Email Card -->
                        <v-card
                            class="card-elevated mb-4"
                            rounded="lg"
                            data-aos="fade-up"
                            data-aos-delay="200"
                        >
                            <v-container>
                                <v-row class="align-center py-4">
                                    <v-col sm="auto" md="auto">
                                        <div class="contact-icon-wrapper">
                                            <v-icon size="28" color="white">mdi-email</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-caption text-grey mb-1">Email</p>
                                        <p class="text-h6 font-weight-bold text-primary">info@techno-triireka.co.id</p>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>

                        <!-- Address Card -->
                        <v-card
                            class="card-elevated"
                            rounded="lg"
                            data-aos="fade-up"
                            data-aos-delay="300"
                        >
                            <v-container>
                                <v-row class="align-center py-4">
                                    <v-col sm="auto" md="auto" align-self="start">
                                        <div class="contact-icon-wrapper mt-2">
                                            <v-icon size="28" color="white">mdi-map-marker</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-caption text-grey mb-1">Alamat</p>
                                        <p class="text-body-2 font-weight-medium mb-3">PT. Techno Triireka</p>
                                        <p class="text-body-2 text-grey-darken-1">
                                            Jl. Boulevard Barat L10, Perumahan Duta Harapan No.Kelurahan, RT.001/RW.013, Harapan Baru, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17123
                                        </p>
                                    </v-col>
                                </v-row>
                                <!-- Map -->
                                <div class="map-wrapper mt-4 mb-2">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.89698286800188!2d107.02060543965501!3d-6.217262397036346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f230ad97ca1%3A0xbb2561281cd38b31!2sTekuno%20Coffee%20%26%20Roastery!5e0!3m2!1sid!2sid!4v1728120726455!5m2!1sid!2sid"
                                        width="100%"
                                        height="180"
                                        style="border:0; border-radius: 8px;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Lokasi PT. Techno Triireka"
                                    ></iframe>
                                </div>
                            </v-container>
                        </v-card>
                    </v-col>

                    <!-- Contact Form Column -->
                    <v-col cols="12" md="7">
                        <v-card
                            class="card-elevated contact-form-card"
                            rounded="lg"
                            data-aos="fade-up"
                            data-aos-delay="200"
                        >
                            <v-container class="pa-8">
                                <div class="mb-6">
                                    <h3 class="text-h5 font-weight-bold text-primary mb-2">Kirim Pesan</h3>
                                    <p class="text-body-2 text-grey">Isi formulir di bawah dan tim kami akan menghubungi Anda secepatnya.</p>
                                </div>

                                <v-form @submit.prevent="submitForm">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                label="Nama Lengkap"
                                                variant="outlined"
                                                density="comfortable"
                                                prepend-inner-icon="mdi-account"
                                                color="#1565C0"
                                                :rules="[v => !!v || 'Nama wajib diisi']"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                label="Email"
                                                variant="outlined"
                                                density="comfortable"
                                                type="email"
                                                prepend-inner-icon="mdi-email"
                                                color="#1565C0"
                                                :rules="[v => !!v || 'Email wajib diisi', v => /.+@.+\..+/.test(v) || 'Email tidak valid']"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                label="Nomor Telepon"
                                                variant="outlined"
                                                density="comfortable"
                                                type="tel"
                                                prepend-inner-icon="mdi-phone"
                                                color="#1565C0"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-select
                                                label="Subjek"
                                                variant="outlined"
                                                density="comfortable"
                                                prepend-inner-icon="mdi-tag"
                                                color="#1565C0"
                                                :items="subjectOptions"
                                            ></v-select>
                                        </v-col>
                                    </v-row>

                                    <v-textarea
                                        label="Pesan Anda"
                                        variant="outlined"
                                        density="comfortable"
                                        rows="5"
                                        prepend-inner-icon="mdi-message-text"
                                        color="#1565C0"
                                        :rules="[v => !!v || 'Pesan wajib diisi']"
                                    ></v-textarea>

                                    <v-btn
                                        type="submit"
                                        color="accent"
                                        size="large"
                                        block
                                        class="font-weight-semibold mt-2"
                                    >
                                        <v-icon start>mdi-send</v-icon>
                                        Kirim Pesan
                                    </v-btn>
                                </v-form>
                            </v-container>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { useHead } from "@unhead/vue";

useHead({
    title: 'Contact Us',
});

const subjectOptions = [
    'Permintaan Penawaran Harga',
    'Konsultasi Teknis',
    'Pertanyaan Produk',
    'Kerjasama Bisnis',
    'Lainnya'
];

function submitForm() {
    // TODO: Implement form submission
    console.log('Form submitted');
}
</script>

<style scoped>
.background-image {
    background-image: url('/images/engineering-services.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.65);
}

.text-white-container {
    position: relative;
    z-index: 1;
}

.contact-form-card {
    min-height: 100%;
}

.contact-icon-wrapper {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
    border-radius: 12px;
    color: white;
}

.map-wrapper {
    border-radius: 12px;
    overflow: hidden;
}

.heading-accent {
    width: 50px;
    height: 4px;
    background: #D32F2F;
    border-radius: 2px;
}
</style>
