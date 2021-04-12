<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to MattPonkCRM!
            </div>
            <div class="mt-6 text-gray-500">
              This App was created to learn Laravel8, Tailwind Css, Netstream & InertiaJS. At the top you will find the menu.
              <br>
              <br>
              In the Customers section you can manage customers: create, read, edit or delete. in the Import/Export section you can import excel files or export your entire customer database.
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
