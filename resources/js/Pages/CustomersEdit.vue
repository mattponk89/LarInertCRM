<template>
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-700 hover:text-green-900" :href="route('customers.index')">&#8592; Customers</inertia-link>
    </h1>
    <div class="bg-white shadow-md rounded">
      <form @submit.prevent="update">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 m-auto">
          <div class="">
            <div class="mb-4">
              <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="name" placeholder="Name..." v-model="form.name">
              <div v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</div>
            </div>
            <div class="mb-4">
              <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
              <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="email" placeholder="Email..." v-model="form.email">
              <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
            </div>
            <div class="mb-4">
              <label for="region" class="block text-gray-700 text-sm font-bold mb-2">Region:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="region" placeholder="Region..." v-model="form.region">
              <div v-if="errors.region" class="text-red-500">{{ errors.region }}</div>
            </div>
            <div class="mb-4">
              <label for="province" class="block text-gray-700 text-sm font-bold mb-2">Province:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="province" placeholder="Province..." v-model="form.province">
              <div v-if="errors.province" class="text-red-500">{{ errors.province }}</div>
            </div>
            <div class="mb-4">
              <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="city" placeholder="City..." v-model="form.city">
              <div v-if="errors.city" class="text-red-500">{{ errors.city }}</div>
            </div>
            <div class="mb-4">
              <label for="cap" class="block text-gray-700 text-sm font-bold mb-2">Zip:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="cap" placeholder="Zip code..." v-model="form.cap">
              <div v-if="errors.cap" class="text-red-500">{{ errors.cap }}</div>
            </div>
            <div class="mb-4">
              <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="address" placeholder="Address..." v-model="form.address">
              <div v-if="errors.address" class="text-red-500">{{ errors.address }}</div>
            </div>
          </div>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Customer</button>
          <button class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" type="submit">Create Customer</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Layout from '@/Layouts/AppLayout'
  import JetButton from '@/Jetstream/Button'

  export default {
    components: {
      JetButton,
    },
    layout: Layout,
    props: {
      customer: Object,
      errors: Object,
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          name: this.customer.name,
          email: this.customer.email,
          address: this.customer.address,
          city: this.customer.city,
          region: this.customer.region,
          province: this.customer.province,
          cap: this.customer.cap,
        }),
      }
    },
    methods: {
      update() {
        this.form.put(this.route('customers.update', this.customer.id))
      },
      destroy() {
        if (confirm('Are you sure you want to delete this customer?')) {
          this.$inertia.delete(this.route('customers.destroy', this.customer))
        }
      },
    },
  }
</script>
