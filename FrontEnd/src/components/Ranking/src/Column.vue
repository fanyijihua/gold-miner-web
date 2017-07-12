<template>
  <div></div>
</template>

<script>
export default {
  name: 'RankingColumn',
  props: ['prop', 'label'],
  created() {
    this.$parent.columnConfig.push({
      prop: this.prop,
      label: this.label,
    })
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

</style>
