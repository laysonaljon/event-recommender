<!DOCTYPE>
<html>
    <head>
        <title>Demand Gen</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out" id="body">

        <!--nav-->
        <nav class="fixed bg-white dark:bg-gray-900  w-full z-20 top-0 left-0 ">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="https://flowbite.com/" class="flex items-center">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Demand Gen</span>
                </a>
                <div class="flex md:order-2">
                    <a href="login.php" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get started</a>
                    <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="file:///Users/aljonlayson/Projects/event-recommender/dashboard.html" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="file:///Users/aljonlayson/Projects/event-recommender/dashboard.html" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                    </li>
                    <li>
                        <a href="file:///Users/aljonlayson/Projects/event-recommender/dashboard.html" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!--Hero-->
        <section class="bg-white dark:bg-gray-900">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">Elevate Your Events with Enhanced Engagement</h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Effortlessly manage, engage, drive demand generation, and increase sales with our ML-powered event platform. Enhance attendee experiences, optimize event outcomes, and foster post-event engagement seamlessly.</p>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                    <img src="https://360degreecloud.com/wp-content/uploads/2021/11/banner-3.png" alt="event">
                </div>                
            </div>
        </section>
        
        
        <!--content1-->
        <section class="bg-white dark:bg-gray-900">
            <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
                <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Customized Event Experiences</h2>
                    <p class="mb-4">Participants receive event journey maps featuring sessions aligned with their chosen interests. Each session includes a QR code for streamlined attendance tracking.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <img class="w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-2.png" alt="office content 1">
                    <img class="mt-4 w-full lg:mt-10 rounded-lg" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-1.png" alt="office content 2">
                </div>
            </div>
        </section>
        
        <!--content2-->
        <section class="bg-white dark:bg-gray-900">
            <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                <img class="w-full dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup.svg" alt="dashboard image">
                <img class="w-full hidden dark:block" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup-dark.svg" alt="dashboard image">
                <div class="mt-4 md:mt-0">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Elevate Events with Enhanced Engagement</h2>
                    <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">Effortlessly manage, engage, drive demand generation, and increase sales with our ML-powered event platform. Enhance attendee experiences, optimize event outcomes, and foster post-event engagement seamlessly.</p>
                    
                </div>
            </div>
        </section>

        <!--process-->
        <section class="bg-white dark:bg-gray-900 antialiased">
            <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6 sm:py-16 lg:py-24">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                        Our Process
                    </h2>
                    <p class="mt-4 text-base font-normal text-gray-500 sm:text-xl dark:text-gray-400">
                        Crafted with expertise to elevate your event experiences!
                    </p>
                </div>
        
                <div class="grid grid-cols-1 mt-12 text-center sm:mt-16 gap-x-20 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-4">
                        <span class="bg-gray-100 text-gray-900 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            Planning & Setup
                        </span>
                        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
                            Seamless Event Planning
                        </h3>
                        <p class="text-lg font-normal text-gray-500 dark:text-gray-400">
                            Start your event journey with easy-to-use planning tools. Customize event details, manage attendee registrations, and set up event preferences effortlessly.
                        </p>
                    </div>
        
                    <div class="space-y-4">
                        <span class="bg-gray-100 text-gray-900 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            Engagement & Interaction
                        </span>
                        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
                            Attendee Experience
                        </h3>
                        <p class="text-lg font-normal text-gray-500 dark:text-gray-400">
                            Enhance attendee engagement with personalized journey maps and session recommendations. Tailor event experiences based on attendee interests to maximize interaction and satisfaction.
                        </p>
                    </div>
        
                    <div class="space-y-4">
                        <span class="bg-gray-100 text-gray-900 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            Post-Event Follow-Up
                        </span>
                        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
                            Continued Engagement
                        </h3>
                        <p class="text-lg font-normal text-gray-500 dark:text-gray-400">
                            Maintain attendee interest with post-event interactions. Send personalized follow-up emails and recommend products based on attendee participation to drive sales and foster long-term engagement.
                        </p>
                    </div>
                </div>
            </div>
        </section>
              
        
        <!--cta-->
        <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Ready to Elevate Your Events?</h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">Join our waitlist to be the first to experience Demand Gen. Receive exclusive updates, early access, and special offers.</p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <button data-modal-target="defaultModal" data-modal-toggle="defaultModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Join our Waitlist</button>
            </div>
        </div>

        
        <!--footer-->
        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-900">
            <div class="mx-auto max-w-screen-xl text-center">
                <hr class="border-gray-200 dark:border-gray-600 mb-6">
                <a href="/test" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Demand Gen</span>
                </a>
                </a>
                <p class="my-6 text-gray-500 dark:text-gray-400">Empower your event planning with our ML-powered platform. Manage, engage, and drive demand effortlessly.</p>
                <hr class="border-gray-200 dark:border-gray-600 mb-6">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="#" class="hover:underline">Demand Gen™</a>. All Rights Reserved.</span>
            </div>
        </footer>
       
        <!--modal-->
        <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-120 flex items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-blue-200 rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <div class="mx-auto max-w-screen-md">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Join the Waitlist</h2>
                            <p class="font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Sign up for early access and updates. Be the first to experience our ML-powered event platform.</p>
                            <div class="p-6 space-y-6">
                                <form action="#" class="space-y-8">
                                    <div>
                                        <label for="waitlist-email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                                        <input type="email" id="waitlist-email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name@flowbite.com" required>
                                    </div>
                                    <button data-modal-hide="defaultModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Join Waitlist</button>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--scripts-->
        <script>
            const modalButtons = document.querySelectorAll('[data-modal-toggle]');
            const modalHideButtons = document.querySelectorAll('[data-modal-hide]');
            const defaultModal = document.getElementById('defaultModal');

            modalButtons.forEach(button => {
                button.addEventListener('click', () => {
                    defaultModal.classList.toggle('hidden');
                });
            });

            modalHideButtons.forEach(button => {
                button.addEventListener('click', () => {
                    defaultModal.classList.add('hidden');
                });
            });
        </script>
    </body>
</html>
