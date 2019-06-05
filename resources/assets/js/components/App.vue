<template>
    <div>
 <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="#"><b>WorkTracker</b> - работа в Казахстане</b-navbar-brand>

    <b-navbar-toggle target="nav_collapse" />   

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Поиск по сайту..." />
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Найти</b-button>
        </b-nav-form>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>

	<b-alert show><b>WorkTracker</b> - работа в Казахстане</b-alert>	
  <center>
		<b-button @click="hello">привет!</b-button>
	</center>
  <br>
  <b-table striped hover  :items="items"></b-table>
  </div>
</template>

<script>

      export default {
        data() {
            return {
                message: 'Hello World',
		items: [
          { Специальность: 40, "з/п": 'Dickerson' },
          { Специальность: 21, "з/п": 'Larsen' },
          { Специальность: 89, "з/п": 'Geneva' },
          { Специальность: 38, "з/п": 'Jami' }
        ]
            }
	},
	methods: {
	hello() {
		alert("hello bro!")
	 }
    }
}
</script>
