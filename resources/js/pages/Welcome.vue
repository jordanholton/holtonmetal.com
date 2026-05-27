<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface InstagramPost {
    id: string;
    caption?: string;
    media_type: 'IMAGE' | 'VIDEO' | 'CAROUSEL_ALBUM';
    media_url: string;
    thumbnail_url?: string;
    permalink: string;
    timestamp: string;
}

const props = defineProps<{
    instagramPosts: InstagramPost[];
    instagramUsername: string;
}>();

const currentYear = new Date().getFullYear();
const mobileMenuOpen = ref(false);

// About section two-panel carousel
const aboutPanel = ref(0);
const slideForward = ref(true);
const aboutTransition = computed(() => (slideForward.value ? 'slide-left' : 'slide-right'));

function goToPanel(index: number) {
    if (index === aboutPanel.value) return;
    slideForward.value = index > aboutPanel.value;
    aboutPanel.value = index;
}
function nextAbout() {
    slideForward.value = true;
    aboutPanel.value = (aboutPanel.value + 1) % 2;
}
function prevAbout() {
    slideForward.value = false;
    aboutPanel.value = ((aboutPanel.value - 1) + 2) % 2;
}

const displayPosts = computed(() => props.instagramPosts?.slice(0, 12) ?? []);
const hasInstagram = computed(() => displayPosts.value.length > 0);
const instagramUrl = computed(() =>
    props.instagramUsername ? `https://instagram.com/${props.instagramUsername}` : 'https://instagram.com',
);
const instagramHandle = computed(() =>
    props.instagramUsername ? `@${props.instagramUsername}` : '@holtonmetal',
);

function getPostImage(post: InstagramPost): string {
    return post.media_type === 'VIDEO' ? (post.thumbnail_url ?? post.media_url) : post.media_url;
}
</script>

<template>
    <Head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div class="min-h-screen bg-[#0a0a0a] text-[#f5f5f5]" style="font-family: 'Inter', sans-serif">
        <!-- ─── HEADER ─────────────────────────────────────────────────── -->
        <header class="fixed top-0 right-0 left-0 z-50 border-b border-[#2a2a2a] bg-[#0a0a0a]/90 backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 select-none">
                    <svg
                        class="h-8 w-8 shrink-0 text-[#e07b39]"
                        viewBox="0 0 64 52"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <!-- Anvil body -->
                        <rect x="6" y="26" width="52" height="16" rx="3" />
                        <!-- Anvil horn taper -->
                        <path d="M6 26 L14 18 H50 L58 26 Z" />
                        <!-- Anvil face/top -->
                        <rect x="14" y="12" width="36" height="6" rx="2" />
                        <!-- Feet -->
                        <rect x="14" y="42" width="8" height="8" rx="1" />
                        <rect x="42" y="42" width="8" height="8" rx="1" />
                    </svg>
                    <div class="leading-none">
                        <div
                            class="text-xl font-bold tracking-[0.15em] text-[#f5f5f5] uppercase"
                            style="font-family: 'Bebas Neue', sans-serif"
                        >
                            Holton Metal
                        </div>
                        <div class="mt-0.5 text-[10px] tracking-[0.35em] text-[#a0a0a0] uppercase">LLC</div>
                    </div>
                </a>

                <!-- Desktop nav -->
                <nav class="hidden items-center gap-8 md:flex">
                    <a
                        v-for="link in [
                            { href: '#work', label: 'Work' },
                            { href: '#about', label: 'About' },
                            { href: '#contact', label: 'Contact' },
                        ]"
                        :key="link.href"
                        :href="link.href"
                        class="text-xs tracking-[0.3em] text-[#a0a0a0] uppercase transition-colors duration-200 hover:text-[#e07b39]"
                    >
                        {{ link.label }}
                    </a>
                    <a
                        :href="instagramUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-1.5 rounded-sm border border-[#2a2a2a] px-4 py-2 text-xs tracking-[0.2em] text-[#a0a0a0] uppercase transition-all duration-200 hover:border-[#e07b39] hover:text-[#e07b39]"
                    >
                        <!-- Instagram icon -->
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                            />
                        </svg>
                        Instagram
                    </a>
                </nav>

                <!-- Mobile menu button -->
                <button
                    class="flex h-9 w-9 items-center justify-center text-[#a0a0a0] md:hidden"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Toggle menu"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    <svg v-if="!mobileMenuOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile nav drawer -->
            <div
                v-if="mobileMenuOpen"
                class="border-t border-[#2a2a2a] bg-[#0a0a0a] px-6 py-4 md:hidden"
            >
                <nav class="flex flex-col gap-4">
                    <a
                        v-for="link in [
                            { href: '#work', label: 'Work' },
                            { href: '#about', label: 'About' },
                            { href: '#contact', label: 'Contact' },
                        ]"
                        :key="link.href"
                        :href="link.href"
                        class="text-sm tracking-[0.3em] text-[#a0a0a0] uppercase transition-colors hover:text-[#e07b39]"
                        @click="mobileMenuOpen = false"
                    >
                        {{ link.label }}
                    </a>
                    <a
                        :href="instagramUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 flex items-center gap-2 text-sm tracking-[0.2em] text-[#e07b39] uppercase"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                            />
                        </svg>
                        {{ instagramHandle }}
                    </a>
                </nav>
            </div>
        </header>

        <!-- ─── HERO ──────────────────────────────────────────────────── -->
        <section class="relative flex min-h-screen items-center justify-center overflow-hidden pt-20">
            <!-- Gradient background -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a] via-[#0f0d0b] to-[#0a0a0a]" />

            <!-- Industrial grid overlay -->
            <div
                class="absolute inset-0 opacity-40"
                style="
                    background-image:
                        linear-gradient(rgba(224, 123, 57, 0.05) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(224, 123, 57, 0.05) 1px, transparent 1px);
                    background-size: 60px 60px;
                "
            />

            <!-- Radial glow -->
            <div
                class="absolute inset-0"
                style="
                    background: radial-gradient(ellipse 60% 50% at 50% 60%, rgba(224, 123, 57, 0.08) 0%, transparent 70%);
                "
            />

            <!-- Hero content -->
            <div class="relative z-10 mx-auto max-w-5xl px-6 text-center">
                <div class="mb-6 text-xs font-medium tracking-[0.6em] text-[#e07b39] uppercase">
                    Custom Blacksmithing &amp; Metalwork
                </div>

                <h1
                    class="mb-6 text-[clamp(4rem,15vw,9rem)] font-bold leading-none uppercase"
                    style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.04em"
                >
                    <span class="block text-[#f5f5f5]">Forged</span>
                    <span class="block text-[#e07b39]">by Hand</span>
                </h1>

                <p class="mx-auto mb-10 max-w-xl text-lg leading-relaxed text-[#a0a0a0] md:text-xl">
                    From custom gates and railings to decorative ironwork — every piece is crafted with
                    traditional blacksmithing techniques and uncompromising attention to detail.
                </p>

                <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                    <a
                        href="#work"
                        class="inline-flex items-center gap-2 bg-[#e07b39] px-8 py-3.5 text-sm tracking-widest text-white uppercase transition-colors duration-200 hover:bg-[#c96a2a]"
                    >
                        View Our Work
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <a
                        href="#contact"
                        class="inline-flex items-center gap-2 border border-[#2a2a2a] px-8 py-3.5 text-sm tracking-widest text-[#a0a0a0] uppercase transition-all duration-200 hover:border-[#e07b39] hover:text-[#e07b39]"
                    >
                        Get a Quote
                    </a>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
                <span class="block h-12 w-px bg-gradient-to-b from-transparent to-[#e07b39]/50" />
            </div>
        </section>

        <!-- ─── INSTAGRAM GRID ────────────────────────────────────────── -->
        <section id="work" class="bg-[#0f0f0f] px-6 py-24">
            <div class="mx-auto max-w-7xl">
                <!-- Section header -->
                <div class="mb-14 text-center">
                    <div class="mb-3 text-xs font-medium tracking-[0.5em] text-[#e07b39] uppercase">Portfolio</div>
                    <h2
                        class="text-5xl font-bold uppercase md:text-6xl"
                        style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em"
                    >
                        Our Work
                    </h2>
                    <div class="mx-auto mt-4 h-0.5 w-16 bg-[#e07b39]" />
                    <p class="mt-5 text-sm text-[#a0a0a0]">
                        See what we're crafting →
                        <a
                            :href="instagramUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="ml-1 text-[#e07b39] transition-colors hover:text-[#f59e0b]"
                        >
                            {{ instagramHandle }}
                        </a>
                    </p>
                </div>

                <!-- Live Instagram feed -->
                <template v-if="hasInstagram">
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:gap-3 lg:grid-cols-4">
                        <a
                            v-for="post in displayPosts"
                            :key="post.id"
                            :href="post.permalink"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group relative aspect-square overflow-hidden bg-[#1a1a1a]"
                        >
                            <img
                                :src="getPostImage(post)"
                                :alt="post.caption ?? 'Holton Metal work'"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <!-- Caption overlay on hover -->
                            <div
                                class="absolute inset-0 flex items-end bg-[#0a0a0a]/0 p-4 transition-all duration-300 group-hover:bg-[#0a0a0a]/75"
                            >
                                <p
                                    class="line-clamp-3 text-xs leading-relaxed text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                >
                                    {{ post.caption }}
                                </p>
                            </div>
                            <!-- Video badge -->
                            <div v-if="post.media_type === 'VIDEO'" class="absolute top-2.5 right-2.5">
                                <div class="rounded-sm bg-[#0a0a0a]/70 p-1">
                                    <svg class="h-3.5 w-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                            <!-- Carousel badge -->
                            <div v-else-if="post.media_type === 'CAROUSEL_ALBUM'" class="absolute top-2.5 right-2.5">
                                <div class="rounded-sm bg-[#0a0a0a]/70 p-1">
                                    <svg class="h-3.5 w-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M2 6h2v12H2zm3 2h2v8H5zm14-2h2v12h-2zm-3 2h2v8h-2zM7 4h10v16H7V4zm2 2v12h6V6H9z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Follow CTA -->
                    <div class="mt-10 text-center">
                        <a
                            :href="instagramUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2.5 border border-[#2a2a2a] px-8 py-3.5 text-sm tracking-widest text-[#a0a0a0] uppercase transition-all duration-200 hover:border-[#e07b39] hover:text-[#e07b39]"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                                />
                            </svg>
                            Follow on Instagram
                        </a>
                    </div>
                </template>

                <!-- Placeholder grid (no token configured yet) -->
                <template v-else>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:gap-3 lg:grid-cols-4">
                        <div
                            v-for="i in 12"
                            :key="i"
                            class="aspect-square border border-[#2a2a2a] bg-[#1a1a1a] flex items-center justify-center"
                        >
                            <svg class="h-8 w-8 text-[#2a2a2a]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-1.1 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"
                                />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-8 text-center text-sm text-[#a0a0a0]">
                        Configure <code class="rounded bg-[#1a1a1a] px-1.5 py-0.5 text-[#e07b39]">INSTAGRAM_ACCESS_TOKEN</code>
                        in your <code class="rounded bg-[#1a1a1a] px-1.5 py-0.5 text-[#e07b39]">.env</code>
                        to display your feed here.
                    </p>
                </template>
            </div>
        </section>

        <!-- ─── ABOUT (two-panel swipe carousel) ─────────────────────── -->
        <section id="about" class="bg-[#0a0a0a] px-6 py-24">
            <div class="mx-auto max-w-4xl">

                <!-- Shared section label -->
                <div class="mb-10 text-center">
                    <div class="mb-2 text-xs font-medium tracking-[0.5em] text-[#e07b39] uppercase">About</div>
                    <!-- Tab pills -->
                    <div class="inline-flex border border-[#2a2a2a] bg-[#141414]">
                        <button
                            class="px-6 py-2.5 text-xs tracking-[0.25em] uppercase transition-all duration-200"
                            :class="aboutPanel === 0
                                ? 'bg-[#e07b39] text-white'
                                : 'text-[#a0a0a0] hover:text-[#f5f5f5]'"
                            @click="goToPanel(0)"
                        >
                            The Craft
                        </button>
                        <button
                            class="px-6 py-2.5 text-xs tracking-[0.25em] uppercase transition-all duration-200"
                            :class="aboutPanel === 1
                                ? 'bg-[#e07b39] text-white'
                                : 'text-[#a0a0a0] hover:text-[#f5f5f5]'"
                            @click="goToPanel(1)"
                        >
                            The Artist
                        </button>
                    </div>
                </div>

                <!-- Slide viewport -->
                <div class="relative overflow-hidden">
                    <Transition :name="aboutTransition" mode="out-in">

                        <!-- Panel 0 — The Craft -->
                        <div v-if="aboutPanel === 0" key="craft" class="grid gap-12 md:grid-cols-2 md:items-center">
                            <div>
                                <h2
                                    class="mb-6 text-4xl font-bold uppercase md:text-5xl"
                                    style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em"
                                >
                                    The Craft
                                </h2>
                                <div class="mb-6 h-0.5 w-16 bg-[#e07b39]" />
                                <p class="mb-4 leading-relaxed text-[#a0a0a0]">
                                    Holton Metal LLC is a custom blacksmithing and fabrication shop dedicated to
                                    the craft of hand-forged metalwork. Every gate, railing, tool, and decorative
                                    piece is made with care using traditional techniques passed down through generations.
                                </p>
                                <p class="leading-relaxed text-[#a0a0a0]">
                                    From architectural ironwork to one-of-a-kind custom commissions, we bring
                                    both function and beauty to every project that comes through our doors.
                                </p>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div
                                    v-for="item in [
                                        { icon: '⚒️', title: 'Hand-Forged', desc: 'Every piece shaped at the anvil, never mass-produced.' },
                                        { icon: '🔥', title: 'Forge-Welded', desc: 'Traditional fire-welding and modern fabrication techniques.' },
                                        { icon: '📐', title: 'Custom Orders', desc: 'Designed and built to your exact specifications.' },
                                    ]"
                                    :key="item.title"
                                    class="flex items-start gap-4 border border-[#2a2a2a] bg-[#141414] p-5"
                                >
                                    <span class="text-2xl" aria-hidden="true">{{ item.icon }}</span>
                                    <div>
                                        <div class="mb-1 text-sm font-semibold tracking-wide text-[#f5f5f5]">{{ item.title }}</div>
                                        <div class="text-sm leading-relaxed text-[#a0a0a0]">{{ item.desc }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 1 — Meet Nathan Holton -->
                        <div v-else key="nathan" class="grid gap-12 md:grid-cols-2 md:items-center">
                            <div>
                                <h2
                                    class="mb-6 text-4xl font-bold uppercase md:text-5xl"
                                    style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em"
                                >
                                    Nathan<br />Holton
                                </h2>
                                <div class="mb-6 h-0.5 w-16 bg-[#e07b39]" />
                                <p class="mb-4 leading-relaxed text-[#a0a0a0]">
                                    Nathan Holton is the founder and sole craftsman behind Holton Metal LLC.
                                    With a lifelong passion for working with metal, Nathan built his skills through
                                    years of hands-on forging — learning the language of iron and fire one heat at a time.
                                </p>
                                <p class="leading-relaxed text-[#a0a0a0]">
                                    Every piece that leaves the shop carries Nathan's signature attention to detail,
                                    rooted in a deep respect for the craft and a commitment to doing things right —
                                    the old way, the hard way, the honest way.
                                </p>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div
                                    v-for="item in [
                                        { icon: '🔨', title: 'Blacksmith & Fabricator', desc: 'Trained in traditional hand-forging with a full modern shop setup.' },
                                        { icon: '🏔️', title: 'One-Man Operation', desc: 'Every order is personally handled by Nathan from design to delivery.' },
                                        { icon: '✦', title: 'Signature Style', desc: 'Bold, functional ironwork with a raw, honest aesthetic.' },
                                    ]"
                                    :key="item.title"
                                    class="flex items-start gap-4 border border-[#2a2a2a] bg-[#141414] p-5"
                                >
                                    <span class="text-2xl" aria-hidden="true">{{ item.icon }}</span>
                                    <div>
                                        <div class="mb-1 text-sm font-semibold tracking-wide text-[#f5f5f5]">{{ item.title }}</div>
                                        <div class="text-sm leading-relaxed text-[#a0a0a0]">{{ item.desc }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </Transition>
                </div>

                <!-- Navigation row -->
                <div class="mt-10 flex items-center justify-center gap-6">
                    <!-- Prev -->
                    <button
                        class="flex h-10 w-10 items-center justify-center border border-[#2a2a2a] text-[#a0a0a0] transition-all duration-200 hover:border-[#e07b39] hover:text-[#e07b39]"
                        aria-label="Previous panel"
                        @click="prevAbout"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Dots -->
                    <div class="flex items-center gap-2.5">
                        <button
                            v-for="i in 2"
                            :key="i"
                            class="transition-all duration-300"
                            :class="aboutPanel === i - 1
                                ? 'h-2 w-6 bg-[#e07b39]'
                                : 'h-2 w-2 bg-[#2a2a2a] hover:bg-[#a0a0a0]'"
                            :aria-label="`Go to panel ${i}`"
                            :aria-current="aboutPanel === i - 1 ? 'true' : undefined"
                            @click="goToPanel(i - 1)"
                        />
                    </div>

                    <!-- Next -->
                    <button
                        class="flex h-10 w-10 items-center justify-center border border-[#2a2a2a] text-[#a0a0a0] transition-all duration-200 hover:border-[#e07b39] hover:text-[#e07b39]"
                        aria-label="Next panel"
                        @click="nextAbout"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

            </div>
        </section>

        <!-- ─── CONTACT ───────────────────────────────────────────────── -->
        <section id="contact" class="border-t border-[#1a1a1a] bg-[#0f0f0f] px-6 py-24">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mb-3 text-xs font-medium tracking-[0.5em] text-[#e07b39] uppercase">Get in Touch</div>
                <h2
                    class="mb-6 text-4xl font-bold uppercase md:text-5xl"
                    style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em"
                >
                    Commission a Piece
                </h2>
                <div class="mx-auto mb-8 h-0.5 w-16 bg-[#e07b39]" />
                <p class="mx-auto mb-10 max-w-xl text-lg leading-relaxed text-[#a0a0a0]">
                    Have a project in mind? Whether it's a custom gate, railing, sculpture, or something
                    entirely unique — reach out and let's talk about bringing it to life.
                </p>
                <a
                    :href="instagramUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-3 bg-[#e07b39] px-10 py-4 text-sm tracking-widest text-white uppercase transition-colors duration-200 hover:bg-[#c96a2a]"
                >
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                        />
                    </svg>
                    Message on Instagram
                </a>
            </div>
        </section>

        <!-- ─── FOOTER ────────────────────────────────────────────────── -->
        <footer class="border-t border-[#1a1a1a] bg-[#0a0a0a] px-6 py-8">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 md:flex-row">
                <!-- Micro logo -->
                <div class="flex items-center gap-2 text-[#a0a0a0]">
                    <svg class="h-5 w-5 shrink-0 text-[#e07b39]" viewBox="0 0 64 52" fill="currentColor" aria-hidden="true">
                        <rect x="6" y="26" width="52" height="16" rx="3" />
                        <path d="M6 26 L14 18 H50 L58 26 Z" />
                        <rect x="14" y="12" width="36" height="6" rx="2" />
                        <rect x="14" y="42" width="8" height="8" rx="1" />
                        <rect x="42" y="42" width="8" height="8" rx="1" />
                    </svg>
                    <span class="text-sm">© {{ currentYear }} Holton Metal LLC. All rights reserved.</span>
                </div>

                <!-- Social links -->
                <a
                    :href="instagramUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-[#a0a0a0] transition-colors hover:text-[#e07b39]"
                    :aria-label="`Follow ${instagramHandle} on Instagram`"
                >
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                        />
                    </svg>
                </a>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* ── About section swipe transitions ─────────────────────────────── */

/* Slide LEFT — advancing forward (The Craft → The Artist) */
.slide-left-enter-active,
.slide-left-leave-active {
    transition:
        transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
        opacity 0.4s ease;
}
.slide-left-enter-from {
    transform: translateX(60px);
    opacity: 0;
}
.slide-left-leave-to {
    transform: translateX(-60px);
    opacity: 0;
}

/* Slide RIGHT — going back (The Artist → The Craft) */
.slide-right-enter-active,
.slide-right-leave-active {
    transition:
        transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
        opacity 0.4s ease;
}
.slide-right-enter-from {
    transform: translateX(-60px);
    opacity: 0;
}
.slide-right-leave-to {
    transform: translateX(60px);
    opacity: 0;
}
</style>

