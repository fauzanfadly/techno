<template>
    <landing-page-layout id="pages-landing-contact">
        <div id="components-landingpage-contact">
            <v-container fluid class="pa-0">
                <v-sheet height="50vh" class="background-image">
                    <div class="overlay"></div>
                    <v-row
                        class="fill-height pt-15"
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12" md="8" class="text-white-container">
                            <p style="font-size: 2.5em" class="text-white text-h3 mb-3">
                                Contact Us
                            </p>
                            <p class="text-white text-subtitle-1">
                                Get in touch with our team of experienced professionals who are dedicated to providing the best possible service to our clients.
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>
        
            <v-container class="py-10 pb-15">
                <v-row>
                    <v-col cols="12">
                        <p class="text-h5">
                            Contact Information
                        </p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col sm="12" md="6">
                        <v-card
                            class="rounded-shaped mb-5"
                            elevation="6"
                        >
                            <v-container>
                                <v-row class="align-center">
                                    <v-col sm="auto" md="auto">
                                        <div class="bg-deep-orange rounded-circle pa-3">
                                            <v-icon size="30">mdi-phone</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-subtitle-1">Call Us</p>
                                        <p class="text-h6">+62 (021) 8887 6969</p>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                        <v-card
                            class="rounded-shaped mb-5"
                            elevation="6"
                        >
                            <v-container>
                                <v-row class="align-center">
                                    <v-col sm="auto" md="auto">
                                        <div class="bg-deep-orange rounded-circle pa-3">
                                            <v-icon size="30">mdi-email</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-subtitle-1">Send Us an E-Mail</p>
                                        <p class="text-h6">+62 (021) 8887 6969</p>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                        <v-card
                            class="rounded-shaped"
                            elevation="6"
                        >
                            <v-container>
                                <v-row class="align-center">
                                    <v-col sm="auto" md="auto" align-self="start">
                                        <div class="bg-deep-orange rounded-circle pa-3 mt-3">
                                            <v-icon size="30">mdi-map-marker</v-icon>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <p class="text-subtitle-1">Visit Us</p>
                                        <p class="text-h6">PT. Techno</p>
                                        <p class="text-subtitle-2">Jl. Boulevard Barat L10, Perumahan Duta Harapan No.Kelurahan, RT.001/RW.013, Harapan Baru, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17123</p>
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.89698286800188!2d107.02060543965501!3d-6.217262397036346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f230ad97ca1%3A0xbb2561281cd38b31!2sTekuno%20Coffee%20%26%20Roastery!5e0!3m2!1sid!2sid!4v1728120726455!5m2!1sid!2sid"
                                            width="100%"
                                            height="200"
                                            style="border:0;"
                                            allowfullscreen=""
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                        ></iframe>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-col>
                    <v-col sm="12" md="6">
                        <v-card
                            class="rounded-shaped contact-form-card"
                            elevation="6"
                        >
                            <v-container>
                                <p class="text-h5 mb-5">Send us a message</p>
                                <v-form>
                                    <v-text-field
                                        label="Full Name"
                                        variant="outlined"
                                        density="comfortable"
                                        class="mb-2"
                                    ></v-text-field>
                                    
                                    <v-text-field
                                        label="Email"
                                        variant="outlined"
                                        density="comfortable"
                                        class="mb-2"
                                    ></v-text-field>
                                    
                                    <v-text-field
                                        label="Phone Number"
                                        variant="outlined"
                                        density="comfortable"
                                        class="mb-2"
                                    ></v-text-field>
                                    
                                    <v-textarea
                                        label="Message"
                                        variant="outlined"
                                        density="comfortable"
                                        class="mb-4"
                                        rows="4"
                                    ></v-textarea>
                                    
                                    <v-btn
                                        color="deep-orange"
                                        size="large"
                                        block
                                        class="text-white"
                                    >
                                        Send Message
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
    background-color: rgba(0, 0, 0, 0.6);
}

.text-white-container {
    position: relative;
    z-index: 1;
}

.contact-form-card {
    height: 100%;
}

.bg-deep-orange {
    background-color: #FF5722;
    color: white;
}
</style>
