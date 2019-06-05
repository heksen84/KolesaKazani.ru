<template>
    <div>
 <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="#"><b>WorkTracker</b> - работа в Казахстане</b-navbar-brand>

    <b-navbar-toggle target="nav_collapse" />

    <!--<b-collapse is-nav id="nav_collapse">
      <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav>
                      -->
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Поиск по сайту..." />
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Найти</b-button>
        </b-nav-form>

        <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">ES</b-dropdown-item>
          <b-dropdown-item href="#">RU</b-dropdown-item>
          <b-dropdown-item href="#">FA</b-dropdown-item>
        </b-nav-item-dropdown>

        <b-nav-item-dropdown right>
          <!-- Using button-content slot -->
          <template slot="button-content"><em>User</em></template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item href="#">Signout</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>

	<!--<b-alert show><b>WorkTracker</b> - работа в Казахстане</b-alert>-->
	<center>
<!--		<b-table striped hover  :items="items" />-->
		<b-button @click="hello">привет!</b-button>
	</center>
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
		alert("hello")
	 }
    }
}
</script>
