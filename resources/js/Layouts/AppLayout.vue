<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
    canView: Boolean
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="wrapper">
                <div class="phone">

                  <nav class="nav nav--icons">
                    <ul>
                      <li>
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                          <svg class="icon icon-home" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="currentColor" d="M21.6 8.2l-9-7c-0.4-0.3-0.9-0.3-1.2 0l-9 7c-0.3 0.2-0.4 0.5-0.4 0.8v11c0 1.7 1.3 3 3 3h14c1.7 0 3-1.3 3-3v-11c0-0.3-0.1-0.6-0.4-0.8zM14 21h-4v-8h4v8zM20 20c0 0.6-0.4 1-1 1h-3v-9c0-0.6-0.4-1-1-1h-6c-0.6 0-1 0.4-1 1v9h-3c-0.6 0-1-0.4-1-1v-10.5l8-6.2 8 6.2v10.5z"></path>
                          </svg>
                          <span>Home</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <ResponsiveNavLink :href="route('products')" :active="route().current('products')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                            <span>Products</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <ResponsiveNavLink :href="route('imports')" :active="route().current('imports')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span>Imports</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <ResponsiveNavLink :href="route('exports')" :active="route().current('exports')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <span>Exports</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <ResponsiveNavLink v-if="canView" :href="route('expences')" :active="route().current('expences')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            <span>Expences</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <ResponsiveNavLink v-if="canView" :href="route('investors')" :active="route().current('investors')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            <span>Investors</span>
                        </ResponsiveNavLink>
                      </li>
                      <li>
                        <a :href="route('profile.show')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                      </li>
                      <li>
                        <a :href="route('profile.show')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        </li>
                    </ul>
                  </nav>

                </div>
            </div>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
 .wrapper {
   max-width: 440px;
   margin: .5em auto;
   position: fixed;
   bottom: 0;
   left: 0;
   right: 0;
   z-index: 50;
 }
 .phone {
   background: #ffffff;
   position: relative;
   overflow: hidden;
   width: 100%;
   height: 80px;
   border-radius: 10px;
 }
 .nav--icons {
   position: absolute;
   bottom: 1.2em;
   left: 1em;
   right: 1em;
 }
 .nav--icons ul {
   list-style-type: none;
   display: flex;
   flex-wrap: nowrap;
   justify-content: space-between;
   padding: 0;
   margin: 0;
 }
 .nav--icons ul li a {
   font-family: sans-serif;
   font-size: 11px;
   letter-spacing: 1px;
   text-decoration: none;
   color: #000;
   line-height: 1;
   vertical-align: middle;
   display: flex;
   align-items: center;
   border-radius: 3em;
   padding: 0.75em 1.25em;
   transition: 0.6s ease-in-out;
 }
 .nav--icons ul li a span {
   display: inline-block;
   overflow: hidden;
   max-width: 0;
   opacity: 0;
   padding-left: 0.5em;
   transform: translate3d(-0.5em, 0, 0);
   transition: opacity 0.6s, max-width 0.6s, transform 0.6s;
   transition-timing-function: ease-in-out;
 }
 .nav--icons ul li a:hover,
 .nav--icons ul li a.is-active {
   color: #fff;
   background-color: #000;
 }
 .nav--icons ul li a:hover span,
 .nav--icons ul li a.is-active span {
   opacity: 1;
   max-width: 40px;
   transform: translate3d(0, 0, 0);
 }
</style>
