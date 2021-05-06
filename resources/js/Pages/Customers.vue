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
          <div v-if="$page.props.flash.success" class="mb-4 flex items-center justify-center text-center bg-green-400 rounded min-w-screen p-4">
            {{ $page.props.flash.success }}
          </div>
          <div v-if="$page.props.flash.errors" class="mb-4 flex items-center justify-center text-center bg-red-400 rounded min-w-screen p-4">
            {{ $page.props.flash.errors }}
          </div>
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
                    <inertia-link class="inline-flex items-center px-4 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition " :href="route('customers.create')">Create New Customer</inertia-link>
                  </div>
                  <div class="bg-white shadow-md rounded">
                    <table class="min-w-max w-full table-auto">
                      <thead>
                      <tr class="bg-green-900 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Customer Name</th>
                        <th class="py-3 px-6 text-left hidden md:table-cell">Email</th>
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
                        <td class="py-3 px-6 text-left hidden md:table-cell">
                          <div class="flex items-center">
                            <span>{{ customer.email }}</span>
                          </div>
                        </td>
                        <td class="py-3 px-6 text-right">
                          <div class="flex item-center justify-end">
                            <inertia-link class="w-4 mr-2 transform hover:text-green-500 hover:scale-110" :href="route('customers.edit', customer)">
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
    'search': Object,
  },
  data() {
    return {
      editMode: false,
      isOpen: false,
      term:this.search,
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
