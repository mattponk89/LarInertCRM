<template>
  <div class="flex items-center">
    <div class="flex w-full bg-white shadow rounded">
      <input class="relative w-full px-6 py-3 rounded-r focus:ring" autocomplete="off" type="text" name="search" placeholder="Search…" :value="value" @input="$emit('input', $event.target.value)" />
    </div>
  </div>
</template>

<script>
import Dropdown from '@/JetStream/Dropdown'

export default {
  components: {
    Dropdown,
  },
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
}
</script>
