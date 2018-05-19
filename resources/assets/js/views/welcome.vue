<template>
  <div>
    <grid>
    <row :reverse="false">123</row>
    <row :reverse="false">
      <column :xs="12" :sm="4" :md="4" :lg="4" style="text-align:left">
        <h1>АксуМаркет</h1>
      </column>
      <column :xs="12" :sm="4" :md="4" :lg="4" style="text-align:center">
        <input type="text" placeholder="строка поиска"></input>
      </column>
      <column :xs="12" :sm="4" :md="4" :lg="4" style="text-align:center">
        <h1>test3</h1>
      </column>
    </row>
  </grid>

  </div>
</template>
<script>
  export default {
    data: () => ({
    }),
    methods: {
      submit () {
      }
    }
  }
</script>
