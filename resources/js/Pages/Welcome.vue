<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    tags: Object,
    categories: Object,
});
</script>

<template>
    <Head title="Welcome"/>

    <GuestLayout>
    <main class="">
        <div class="container max-w-6xl mx-auto">
            <div class="w-full flex mt-16 pb-10">
                <div class="w-1/2">
                    <div>
                        <h1 class="text-6xl font-bold">notionism</h1>
                        <div class="flex flex-nowrap items-center mt-5">
                            <svg class="h-8" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 171.55 26.44"><path d="M23.19,16.61l0-2.48A6.14,6.14,0,0,0,22.91,12a2.35,2.35,0,0,0-.66-.92,1.68,1.68,0,0,0-1.07-.31,9.07,9.07,0,0,0-2.86,1.06c-.19.11-.29.22-.3.32v6.31a1.27,1.27,0,0,0,1.26,1.36c.37.05.56.14.56.26s0,.19-.12.21H14.49a.15.15,0,0,1-.12-.17c0-.15.19-.25.56-.3a1.27,1.27,0,0,0,1.26-1.36V11.74a.69.69,0,0,0-.54-.68,3.31,3.31,0,0,0-.5-.13l-.43-.1a.46.46,0,0,1-.2-.09.26.26,0,0,1,0-.18c0-.09.06-.16.18-.22l3-1.41a.62.62,0,0,1,.18-.07c.13,0,.2.09.2.28V11q0,.12.09.12a2.08,2.08,0,0,0,.51-.22c.67-.33,1.34-.66,2-1a4.34,4.34,0,0,1,1.69-.47Q25,9.43,25,14.37l-.11,3.42v.68a1.15,1.15,0,0,0,.92,1.19,4.48,4.48,0,0,0,.74.19,1.6,1.6,0,0,1,.47.1.18.18,0,0,1,.11.18.15.15,0,0,1-.12.17H21.41a.15.15,0,0,1-.12-.17c0-.15.18-.25.55-.3a1.31,1.31,0,0,0,1.25-1.46A11,11,0,0,0,23.19,16.61Z"/><path d="M35.3,16.51c.13,0,.19-.24.19-.71a6.06,6.06,0,0,0-.72-3.29,4,4,0,0,0-2-1.54,3.73,3.73,0,0,0-1.18-.21,3,3,0,0,0-1.84.6,3,3,0,0,0-.66.46,2.47,2.47,0,0,1-.51.38h-.06a.15.15,0,0,1-.12-.07.38.38,0,0,0-.11-.11c0-.16.14-.36.43-.59a4.63,4.63,0,0,1,1.06-.87,5,5,0,0,1,2.93-1.13A4,4,0,0,1,35.91,11a5.35,5.35,0,0,1,1.28,3.53,7,7,0,0,1-1.35,4.28,4.37,4.37,0,0,1-3.72,1.83,3.8,3.8,0,0,1-2-.48A4.64,4.64,0,0,1,28.55,18a2.85,2.85,0,0,1-.32-1.1c0-.27.09-.41.28-.41Zm-.12.77a.2.2,0,0,0-.22-.22h-4.3c-.2,0-.3.12-.3.37a2.34,2.34,0,0,0,.7,1.61,2.09,2.09,0,0,0,1.6.76,2.26,2.26,0,0,0,1.61-.69,3.31,3.31,0,0,0,.91-1.68Z"/><path d="M48.43,10.63c.18.37.36.72.55,1a6.45,6.45,0,0,1,1,3.22A5.45,5.45,0,0,1,48.34,19a4.91,4.91,0,0,1-7.25,0,5.08,5.08,0,0,1-1.67-3.8,6.9,6.9,0,0,1,1-3.54c.19-.32.37-.67.55-1H39.61l.19-.88h3.72l.06.88H43c-.43,0-.86.49-1.3,1.49a6.73,6.73,0,0,0-.66,2.7,5.46,5.46,0,0,0,1.07,3.51,3.28,3.28,0,0,0,5.27,0,4.73,4.73,0,0,0,1.07-3,7.74,7.74,0,0,0-.66-3.18c-.44-1-.87-1.49-1.3-1.49h-.61l.06-.88h3.71l.2.88Z"/><path d="M56.2,7.24l0,1.69v9.28c0,2.66-.88,4.41-2.62,5.23a4.64,4.64,0,0,1-2,.42,2,2,0,0,1-1.68-.65.8.8,0,0,1-.2-.57c0-.43.27-.69.82-.78a1.55,1.55,0,0,1,.71.15,6.37,6.37,0,0,1,.55.35,5.07,5.07,0,0,0,.55.34,1.42,1.42,0,0,0,.72.16c.94,0,1.4-1,1.4-3l0-1.69V8.93c0-2.66.87-4.41,2.61-5.23a4.71,4.71,0,0,1,2-.42,2.07,2.07,0,0,1,1.69.65.84.84,0,0,1,.2.57c0,.43-.28.69-.82.78a1.52,1.52,0,0,1-.71-.15,5.14,5.14,0,0,1-.55-.35,6.26,6.26,0,0,0-.55-.34,1.47,1.47,0,0,0-.72-.16C56.67,4.28,56.2,5.27,56.2,7.24Z"/><path d="M66.72.12a.26.26,0,0,1,.2-.12c.07,0,.17.09.3.28a.82.82,0,0,1,.19.41.45.45,0,0,1-.07.25,21.93,21.93,0,0,0,0,24.56.51.51,0,0,1,.07.26.84.84,0,0,1-.19.4c-.13.19-.23.28-.3.28a.26.26,0,0,1-.2-.12,19.9,19.9,0,0,1-4.35-9.55,22,22,0,0,1-.29-3.53,21.25,21.25,0,0,1,1.18-7A18.68,18.68,0,0,1,66.72.12Z"/><path d="M75.59,16.51c.13,0,.19-.24.19-.71a6,6,0,0,0-.73-3.29,3.88,3.88,0,0,0-2-1.54,3.73,3.73,0,0,0-1.18-.21,3,3,0,0,0-1.84.6,3,3,0,0,0-.66.46,2.47,2.47,0,0,1-.51.38h-.06a.15.15,0,0,1-.12-.07.38.38,0,0,0-.11-.11c0-.16.14-.36.43-.59a4.63,4.63,0,0,1,1.06-.87A5,5,0,0,1,73,9.43,4,4,0,0,1,76.2,11a5.4,5.4,0,0,1,1.28,3.53,7,7,0,0,1-1.35,4.28,4.39,4.39,0,0,1-3.72,1.83,3.8,3.8,0,0,1-2-.48A4.64,4.64,0,0,1,68.84,18a2.69,2.69,0,0,1-.32-1.1c0-.27.09-.41.28-.41Zm-.13.77a.19.19,0,0,0-.21-.22H71c-.2,0-.3.12-.3.37a2.34,2.34,0,0,0,.7,1.61,2.09,2.09,0,0,0,1.6.76,2.26,2.26,0,0,0,1.61-.69,3.22,3.22,0,0,0,.9-1.68Z"/><path d="M79,.94a.62.62,0,0,1-.08-.33A.56.56,0,0,1,79.1.2a.92.92,0,0,1,.3-.2s.1,0,.17.12a18.83,18.83,0,0,1,4.34,9.57,21.18,21.18,0,0,1,.3,3.55,20.88,20.88,0,0,1-1.2,7,19.67,19.67,0,0,1-3.44,6.09.27.27,0,0,1-.2.12c-.07,0-.17-.09-.3-.28a.89.89,0,0,1-.2-.4A.52.52,0,0,1,79,25.5,21.93,21.93,0,0,0,79,.94Z"/><path d="M95.63,16.61l0-2.48A6.08,6.08,0,0,0,95.35,12a2.33,2.33,0,0,0-.65-.92,1.71,1.71,0,0,0-1.08-.31,9,9,0,0,0-2.85,1.06c-.2.11-.3.22-.31.32v6.31a1.28,1.28,0,0,0,1.27,1.36c.37.05.55.14.55.26s0,.19-.12.21H86.94a.15.15,0,0,1-.12-.17c0-.15.18-.25.55-.3a1.28,1.28,0,0,0,1.27-1.36V11.74a.69.69,0,0,0-.54-.68,3.8,3.8,0,0,0-.51-.13l-.42-.1a.41.41,0,0,1-.2-.09.26.26,0,0,1,0-.18c0-.09,0-.16.17-.22l3-1.41a.46.46,0,0,1,.18-.07c.13,0,.19.09.19.28V11c0,.08.06.12.1.12a2.1,2.1,0,0,0,.5-.22c.67-.33,1.35-.66,2-1a4.3,4.3,0,0,1,1.69-.47q2.7,0,2.7,4.94l-.1,3.42v.68a1.14,1.14,0,0,0,.91,1.19,4.58,4.58,0,0,0,.75.19,1.69,1.69,0,0,1,.47.1.18.18,0,0,1,.11.18.15.15,0,0,1-.12.17H93.85a.15.15,0,0,1-.12-.17c0-.15.19-.25.56-.3a1.32,1.32,0,0,0,1.25-1.46A12.63,12.63,0,0,0,95.63,16.61Z"/><path d="M105.43,10s-.13.05-.4.05a1.41,1.41,0,0,0-.74.21.94.94,0,0,0-.34.86v8a.73.73,0,0,0,.37.7,2.17,2.17,0,0,0,1,.19.06.06,0,0,1,.07.07v.18s0,.06-.07.06h-4.58s-.08,0-.08-.06v-.18s.14-.07.4-.07a1.36,1.36,0,0,0,.74-.21.93.93,0,0,0,.33-.85V11a.73.73,0,0,0-.37-.7,1.57,1.57,0,0,0-.72-.2c-.24,0-.36,0-.36-.05V9.81s0-.06.07-.06h4.61s.07,0,.07.06Z"/><path d="M109.88,18.94a.23.23,0,0,0,0,.14c0,.06,0,.09.07.09h4.51a1.57,1.57,0,0,0,1.29-.92,6.05,6.05,0,0,1,.52-.79.42.42,0,0,1,.29-.14c.11,0,.16.05.16.14l-.87,2.3-.09.29c0,.16-.12.25-.24.25h-8.26c-.17,0-.25-.08-.25-.24a.57.57,0,0,1,.07-.29l5.89-8.09.21-.28a.59.59,0,0,0,.1-.26c0-.09-.51-.14-1.55-.14h-2.4c-.64,0-1.09.4-1.35,1.19l-.24.75c-.09.3-.2.44-.34.44s-.11,0-.11,0l.66-3.92a.19.19,0,0,1,.2-.14q.15,0,.3.24a.43.43,0,0,0,.34.26,18.56,18.56,0,0,0,2.4.12c1,0,2.66,0,4.93-.07.08,0,.12.12.12.29a.47.47,0,0,1-.19.4l-6,8.29A.77.77,0,0,0,109.88,18.94Z"/><path d="M123.61.12A.24.24,0,0,1,123.8,0c.08,0,.17.09.3.28a.87.87,0,0,1,.2.41.55.55,0,0,1-.07.25,21.93,21.93,0,0,0,0,24.56.63.63,0,0,1,.07.26.89.89,0,0,1-.2.4c-.13.19-.22.28-.3.28a.24.24,0,0,1-.19-.12,19.71,19.71,0,0,1-4.35-9.55,20.93,20.93,0,0,1-.29-3.53,21.5,21.5,0,0,1,1.17-7A18.71,18.71,0,0,1,123.61.12Z"/><path d="M132.48,16.51c.12,0,.18-.24.18-.71a6.06,6.06,0,0,0-.72-3.29A3.9,3.9,0,0,0,130,11a3.72,3.72,0,0,0-1.17-.21,3,3,0,0,0-1.84.6,2.94,2.94,0,0,0-.67.46,3,3,0,0,1-.5.38h-.06a.16.16,0,0,1-.13-.07.38.38,0,0,0-.11-.11c0-.16.15-.36.44-.59a4.53,4.53,0,0,1,1-.87,5,5,0,0,1,2.93-1.13A4,4,0,0,1,133.09,11a5.39,5.39,0,0,1,1.27,3.53A7,7,0,0,1,133,18.78a4.37,4.37,0,0,1-3.72,1.83,3.8,3.8,0,0,1-2-.48A4.64,4.64,0,0,1,125.73,18a2.73,2.73,0,0,1-.33-1.1c0-.27.09-.41.28-.41Zm-.13.77a.19.19,0,0,0-.21-.22h-4.3c-.21,0-.31.12-.31.37a2.34,2.34,0,0,0,.7,1.61,2.1,2.1,0,0,0,1.6.76,2.25,2.25,0,0,0,1.61-.69,3.24,3.24,0,0,0,.91-1.68Z"/><path d="M135.83.94a.62.62,0,0,1-.07-.33A.53.53,0,0,1,136,.2c.15-.13.25-.2.3-.2s.1,0,.16.12a18.76,18.76,0,0,1,4.35,9.57,22.27,22.27,0,0,1,.29,3.55,20.88,20.88,0,0,1-1.2,7,19.47,19.47,0,0,1-3.44,6.09.26.26,0,0,1-.2.12c-.07,0-.17-.09-.3-.28a.84.84,0,0,1-.19-.4.51.51,0,0,1,.07-.26,21.93,21.93,0,0,0,0-24.56Z"/><path d="M159.36,16.61l0-2.48a6.08,6.08,0,0,0-.26-2.12,2.25,2.25,0,0,0-.66-.92,1.66,1.66,0,0,0-1.07-.31,9,9,0,0,0-2.85,1.06c-.2.11-.3.22-.31.32v6.31a1.27,1.27,0,0,0,1.27,1.36c.36.05.55.14.55.26s0,.19-.12.21h-5.23a.15.15,0,0,1-.11-.17c0-.15.18-.25.55-.3a1.27,1.27,0,0,0,1.26-1.36V12.63c0-1.22-.75-1.84-2.27-1.84a4.76,4.76,0,0,0-2.31,1,2.5,2.5,0,0,0-.55.45v6.24a1.27,1.27,0,0,0,1.27,1.36c.36.05.55.14.55.26s0,.19-.12.21H143.7a.15.15,0,0,1-.11-.17c0-.15.18-.25.55-.3a1.26,1.26,0,0,0,1.26-1.34V11.74a.69.69,0,0,0-.54-.68,3.31,3.31,0,0,0-.5-.13l-.43-.1a.54.54,0,0,1-.2-.09.34.34,0,0,1,0-.18c0-.09.06-.16.18-.22l3-1.41a.51.51,0,0,1,.17-.07c.13,0,.2.09.2.28v1.95a.09.09,0,0,0,.09.07,1.46,1.46,0,0,0,.39-.17l.81-.46c.34-.2.78-.43,1.33-.7a4,4,0,0,1,1.75-.4,2.21,2.21,0,0,1,2.13,1.28c.17.34.32.49.45.44s.34-.15.62-.29c.67-.33,1.34-.65,2-1a4.3,4.3,0,0,1,1.68-.47q2.72,0,2.71,4.94l-.1,3.42v.68a1.14,1.14,0,0,0,.91,1.19,4.75,4.75,0,0,0,.74.19,1.6,1.6,0,0,1,.47.1.17.17,0,0,1,.11.18.15.15,0,0,1-.11.17h-5.65a.15.15,0,0,1-.12-.17c0-.15.18-.25.55-.3a1.32,1.32,0,0,0,1.26-1.46A12.63,12.63,0,0,0,159.36,16.61Z"/><path d="M12,3.75v7.32H10.34V3.75Z"/><path d="M5.82,1.8v1H2.65a.76.76,0,0,0-.86.86V24.23a.76.76,0,0,0,.86.86H6.09v1H0V1.8Z"/><path d="M169.76,3.67a.75.75,0,0,0-.84-.86h-3.21v-1h5.84V26.1h-6.1v-1h3.47a.75.75,0,0,0,.84-.86Z"/></svg>
                            <span class="italic text-gray-500 text-3xl ml-8">noun</span>
                        </div>
                        <div class="w-full border-b border-gray-600 my-5"></div>
                        <ul class="list-disc pl-4 font-light">
                            <li class="mb-2">a philosophy which states what everything should be organized using Notion</li>
                            <li class="mb-2">a website with solutions and learning resources for Notion enthusiasts </li>
                        </ul>
                    </div>
                    <div class="mt-8">
                        <button class="px-4 py-2 font-semibold text-center text-lg rounded-md bg-rose-600 text-white inline-flex items-center">
                            Browse templates
                            <svg xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 ml-1 fill-white"><path fill-rule="evenodd" d="M11.767 4.455c.44-.44 1.152-.44 1.591 0l6.75 6.75c.44.439.44 1.151 0 1.59l-6.75 6.75a1.125 1.125 0 0 1-1.591-1.59l4.83-4.83H4.686a1.125 1.125 0 0 1 0-2.25h11.91l-4.83-4.83a1.125 1.125 0 0 1 0-1.59Z" clip-rule="evenodd"/></svg>

                        </button>
                    </div>

                </div>
                <div class="w-1/2 relative">
                    <img class="w-4/6 float-right" src="https://notionism.org/wp-content/uploads/2022/12/philisopher-transparent-mirrored.png">
                    <svg class="absolute -z-10 -top-20 -left-20" width="915" height="786" viewBox="0 0 915 786" fill="none" xmlns="https://www.w3.org/2000/svg">
                        <ellipse cx="457.027" cy="392.819" rx="532.5" ry="281" transform="rotate(-37.2102 457.027 392.819)" fill="url(#paint0_radial_4_35)"/>
                        <defs>
                            <radialGradient id="paint0_radial_4_35" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(457.027 392.819) rotate(90) scale(281 532.5)">
                                <stop stop-color="#D8F7ED"/>
                                <stop offset="1" stop-color="white" stop-opacity="0"/>
                            </radialGradient>
                        </defs>
                    </svg>
                    <svg class="absolute -z-10 -top-20 left-20" width="877" height="786" viewBox="0 0 877 786" fill="none" xmlns="https://www.w3.org/2000/svg">
                        <ellipse cx="457.027" cy="392.819" rx="532.5" ry="281" transform="rotate(-37.2102 457.027 392.819)" fill="url(#paint0_radial_4_34)"/>
                        <defs>
                            <radialGradient id="paint0_radial_4_34" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(457.027 392.819) rotate(90) scale(281 532.5)">
                                <stop stop-color="#FAD1F1"/>
                                <stop offset="1" stop-color="white" stop-opacity="0"/>
                            </radialGradient>
                        </defs>
                    </svg>

                </div>

            </div>
            <div>
                <h2 class="font-semibold text-3xl">Notion Templates</h2>
                <div class="flex w-full">
                    <div class="inline-flex bg-gray-100 rounded-lg p-5 items-start my-5">
                        <div class="px-2 text-xl">💡</div>
                        <span class="mt-0.5 text-gray-600">We just launched and do not cover all the categories yet. We are actively creating templates, <a href="mailto:theilchikus@gmail.com" class="text-rose-600 hover:underline"> write us </a>  if you want to contribute to the Notion community, upvote categories you are interested in or add what we've missed out. Below is the list of all planned categories.</span>
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 mt-4 pb-10 mb-10">
                    <div>
                        <h3 class="font-semibold text-xl">Case</h3>
                        <span class="text-gray-500">what you want to track or manage</span>
                        <ul class="w-full columns-2 mt-4 mb-8">
                            <li class='font-light mb-1'>🗓️ Weekly planner</li>
                            <li class='font-light mb-1'>🤓 Reading</li>
                            <li class='font-light mb-1'>💳 Finances</li>
                            <li class='font-light mb-1'>🎯 Goals</li>
                            <li class='font-light mb-1'>🏗️ Project management</li>
                            <li class='font-light mb-1'>🔁 Habits</li>
                            <li class='font-light mb-1'>🏋️ Workout</li>
                            <li class='font-light mb-1'>🥗 Meal planner</li>
                            <li class='font-light mb-1'>🏝️ Travel</li>
                            <li class='font-light mb-1'>🧑‍🍳 Recepies</li>
                            <li class='font-light mb-1'>✅ Task management</li>
                            <li class='font-light mb-1'>🔥 Productivity tracker</li>
                            <li class='font-light mb-1'>📜 Resume</li>
                            <li class='font-light mb-1'>💼 Portfolio</li>
                            <li class='font-light mb-1'>📚 Wiki</li>
                            <li class='font-light mb-1'>💬 Meetings</li>
                            <li class='font-light mb-1'>🛒 Shopping list</li>
                            <li class='font-light mb-1'>👋 CRM</li>
                            <li class='font-light mb-1'>🏦 Stocks</li>
                            <li class='font-light mb-1'>📑 Assignments</li>
                            <li class='font-light mb-1'>📒 Journal</li>
                            <li class='font-light mb-1'>🧾 Invoicing</li>
                            <li class='font-light mb-1'>✍️ Book writing</li>
                            <li class='font-light mb-1'>👪 Team management</li>
                            <li class='font-light mb-1'>📝 Notes</li>
                            <li class='font-light mb-1'>📅 Syllabus </li>
                            <li class='font-light mb-1'>📨 College Application</li>
                            <li class='font-light mb-1'>📦 Order processing</li>
                            <li class='font-light mb-1'>🪜Inventory management</li>
                            <li class='font-light mb-1'>🌐 SEO</li>
                            <li class='font-light mb-1'>🐲 Dungeons & Dragons</li>
                            <li class='font-light mb-1'>📁 CMS</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xl">Field</h3>
                        <span class="text-gray-500">domain/sphere of templates application</span>
                        <ul class="w-full columns-2 mt-4 mb-8">
                            <li class='font-light mb-1'>🎓Education</li>
                            <li class='font-light mb-1'>🧑‍💼 Professionals</li>
                            <li class='font-light mb-1'>🧬 Life</li>
                            <li class='font-light mb-1'>👔 Business</li>
                            <li class='font-light mb-1'>🙋 Students</li>
                            <li class='font-light mb-1'>🎒 High School</li>
                            <li class='font-light mb-1'>🏫 College</li>
                            <li class='font-light mb-1'>🤸‍♂️ Daily Routine</li>
                            <li class='font-light mb-1'>👨‍🎨 Content creators</li>
                            <li class='font-light mb-1'>🧑‍🎓 University</li>
                            <li class='font-light mb-1'>📰 Bloggers</li>
                            <li class='font-light mb-1'>🎬 Video creators</li>
                            <li class='font-light mb-1'>📈 Marketers</li>
                            <li class='font-light mb-1'>🛠️ Developers</li>
                            <li class='font-light mb-1'>🫀 Health</li>
                            <li class='font-light mb-1'>👶 Small business/SMB</li>
                            <li class='font-light mb-1'>🚀 Startup</li>
                            <li class='font-light mb-1'>🧑‍⚕️ Medical School</li>
                            <li class='font-light mb-1'>🧑‍🏫 Teachers</li>
                            <li class='font-light mb-1'>👨‍💻 Freelancers</li>
                            <li class='font-light mb-1'>💁 Self care</li>
                            <li class='font-light mb-1'>🛍️ Ecommerce</li>
                            <li class='font-light mb-1'>🎨 Designers</li>
                            <li class='font-light mb-1'>🤝 Agency</li>
                            <li class='font-light mb-1'>👨‍⚖️ Law School</li>
                            <li class='font-light mb-1'>💪 Self improvement</li>
                            <li class='font-light mb-1'>😂 Entertaiment</li>
                        </ul>


                    </div>
                    <div>
                        <h3 class="font-semibold text-xl">Book</h3>
                        <span class="text-gray-500">book-inspired categories</span>
                        <ul class="w-full columns-2 mt-4 mb-8">
                            <li class='font-light mb-1'>⚛️ Atomic habits</li>
                            <li class='font-light mb-1'>🏁 Getting Things Done</li>
                            <li class='font-light mb-1'>🌞 The Miracle Morning</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xl">Look</h3>
                        <span class="text-gray-500">appearance features</span>
                        <ul class="w-full columns-2 mt-4 mb-8">
                            <li class='font-light mb-1'>🔲 Minimalism</li>
                            <li class='font-light mb-1'>🦹 Anime</li>
                            <li class='font-light mb-1'>😍 Aesthetic</li>
                            <li class='font-light mb-1'>😇 Cute</li>
                        </ul>
                    </div>

                </div>


            </div>
            <h2 class="font-semibold text-3xl mt-20">What is Notionism?</h2>

            <div class="grid grid-cols-2 mt-10 gap-16 mb-20">
                <div>
                    <h2 class="text-2xl font-semibold mb-2">ℹ️ About us</h2>
                    <p>We are 2-man team of Notion and productivity enthusiasts with development and content creation background. We started sharing knowledge with each other, but now it's time to spread it more.</p>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold mb-2">🎯 Mission</h2>
                    <p>We are sure that Notion is truly amazing tool for anything, but developing workspace by your own can take a lot of time and efforts. Notionism is here to connect enthusiasts so we could share the knowledge and solutions</p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold mb-2">👁️ Vision</h2>
                    <p>Our first priority is to provide templates so Notion users could instantly benefit from using them. Later on we'll make it possible for anyone to share their templates, guides and ideas. Also, Notion automations are on the way</p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold mb-2">🪙 Pricing</h2>
                    <p>We believe that anyone should have unlimited access for self-improvement and educational tools: all templates for personal use are free forever. Business templates cost proportionally to their complexity.</p>
                </div>
            </div>

        </div>
    </main>

    </GuestLayout>
</template>

