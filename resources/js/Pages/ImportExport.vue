<template>
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-700 hover:text-green-900" :href="route('customers.index')">&#8592; Customers</inertia-link>
    </h1>
    <div class="bg-white shadow-md rounded flex justify-around p-5">
      <form @submit.prevent="submit" class="p-4">
        <h2 class="mb-2 font-bold text-2xl">IMPORT</h2>
        <div>
          <input type="file" @input="form.file = $event.target.files[0]" />
          <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
          </progress>
          <button class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" type="submit">Import Customers</button>

        </div>
        <div v-if="errors.file" class="text-red-500">{{ errors.file }}</div>
      </form>
      <form action="/file-export" target="_blank" method="GET" enctype="multipart/form-data" class="border-l-2 p-4 self-center">
        <H2 class="mb-2 font-bold text-2xl">EXPORT</H2>
        <button class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">Export All Customers</button>
      </form>

    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/AppLayout'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
  layout: Layout,
  props: {
    errors: Object,
  },
  setup () {
    const form = useForm({
      file: null,
    })

    function submit() {
      form.post('/file-import')
    }

    return { form, submit }
  },
}
</script>
