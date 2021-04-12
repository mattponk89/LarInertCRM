<template>
  <div>
    <app-layout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Customers
        </h2>
      </template>

      <div class="mb-12 pt-3">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- component -->
            <div class="overflow-x-auto">
              <div class="min-w-screen bg-gray-100 flex items-start justify-center bg-gray-100 font-sans overflow-hidden">
                <div class="w-full">
                  <div class="flex justify-between p-2">
                    <div class=" py-2 px-4 rounded m-3">
                      <label for="search" class="mr-2 text-gray-700 text-sm font-bold mb-2">Search:</label>
                      <input id="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="search" v-model="term" @keyup="search" placeholder="Search..">
                    </div>
                    <inertia-link class="inline-flex items-center px-4 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" :href="route('customers.create')">Create New Customer</inertia-link>
                  </div>
                  <div class="bg-white shadow-md rounded">
                    <table class="min-w-max w-full table-auto">
                      <thead>
                      <tr class="bg-green-900 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Customer Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-right">Actions</th>
                      </tr>
                      </thead>
                      <tbody class="text-gray-600 text-sm font-light">
                      <tr class="border-b border-gray-200 hover:bg-green-700 hover:text-white" v-for="(customer, index) in customers.data" :key="customer.id" :class="{'bg-gray-200': index%2 === 1 }">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                          <div class="flex items-center">
                            <span class="font-medium">{{ customer.name }}</span>
                          </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                          <div class="flex items-center">
                            <span>{{ customer.email }}</span>
                          </div>
                        </td>
                        <td class="py-3 px-6 text-right">
                          <div class="flex item-center justify-end">
                            <div @click="show(customer)" class="w-4 mr-2 transform hover:text-green-500 hover:scale-110">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                              </svg>
                            </div>
                            <inertia-link class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" :href="route('customers.edit', customer)">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                              </svg>
                            </inertia-link>
                            <div @click="deleteRow(customer)" class="w-4 transform hover:text-red-500 hover:scale-110">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                              </svg>
                            </div>
                          </div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                    <div class="p-3 flex justify-end">
                      <pagination :links="customers.links" />

                    </div>

                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form @submit="checkForm" >
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
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
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                              <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">Save</button>
                              </span>
                              <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">Update</button>
                              </span>
                              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button @click="closeModal(); reset()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">Cancel</button>
                              </span>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </app-layout>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Jetstream/Pagination'
import _ from 'lodash'

export default {
  components: {
    AppLayout,
    Pagination
  },
  props: {
    'customers': Object,
  },
  data() {
    return {
      editMode: false,
      isOpen: false,
      term:"",
    }
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },
    closeModal() {
      this.isOpen = false;
      this.editMode = false;
    },
    search: _.throttle(function() {
      this.$inertia.get('/customers', {
        term: this.term
      },{
        preserveState: true,
      })
    }),
    create() {
        this.$inertia.post('/customers/create')
    },
    edit(customer) {
        customer._method= 'GET';
        this.$inertia.get('/customers/' + customer.id, customer)
    },
    deleteRow(customer) {
      if (!confirm('Are you sure want to remove?')) return;
      customer._method = 'DELETE';
      this.$inertia.post('/customers/' + customer.id, customer);
    }
  }
}
</script>
