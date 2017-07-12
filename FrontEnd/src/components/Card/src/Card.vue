<template>
  <div class="card" :class="size && `card--${size}`">
    <h2 class="card__title">{{ title }}</h2>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title', 'size'],
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.card {
  padding: 20px;
  border: 1px solid $gray;
  border-radius: 6px;

  &--small {
    padding: 15px;

    .card__title {
      font-size: 16px;
    }
  }

  &__title {
    margin: 0;
    color: $silver-light;
  }
}
</style>
