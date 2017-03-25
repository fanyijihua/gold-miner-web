<template>
  <div class="card">
    <h2 class="card__title">{{ title }}</h2>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title'],
  data() {
    return {
    }
  },
}
</script>

<style lang="scss" scope>
@import "~styles/exports";

.card {
  padding: 20px;
  border: 1px solid $gray;
  border-radius: 6px;

  &__title {
    margin: 0;
    color: $silver-light;
  }
}
</style>
