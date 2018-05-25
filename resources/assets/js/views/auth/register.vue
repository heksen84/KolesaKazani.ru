<template>
  <b-container fluid>
    <b-row>
    <b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
    <h1>регистрация</h1>
    <b-form @submit="onSubmit" @reset="onReset" v-if="show" style="width:99%">
      <b-form-group id="exampleInputGroup1"
                    label="Email адрес:"
                    label-for="exampleInput1">
        <b-form-input id="exampleInput1"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введи email">
        </b-form-input>
      </b-form-group>
      <b-form-group id="exampleInputGroup2"
                    label="Твой пароль:"
                    label-for="exampleInput2">
        <b-form-input id="exampleInput2"
                      type="text"
                      v-model="form.name"
                      required
                      placeholder="Введи пароль">
        </b-form-input>
      </b-form-group>
      <b-form-group id="exampleGroup4">
        <b-form-checkbox-group v-model="form.checked" id="exampleChecks">
          <b-form-checkbox value="me">запомнить меня</b-form-checkbox>
        </b-form-checkbox-group>
      </b-form-group>
      <b-button type="submit" variant="primary">Продолжить</b-button>
      <!--<b-button type="reset" variant="danger">Reset</b-button>-->
    </b-form>
  </b-col>
  </b-row>
</b-container>
</template>

<script>
export default {
  data () {
    return {
      form: {
        email: '',
        name: '',
        food: null,
        checked: []
      },
      foods: [
        { text: 'Select One', value: null },
        'Carrots', 'Beans', 'Tomatoes', 'Corn'
      ],
      show: true
    }
  },
  methods: {
    onSubmit (evt) {
      evt.preventDefault();
      alert(JSON.stringify(this.form));
    },
    onReset (evt) {
      evt.preventDefault();
      /* Reset our form values */
      this.form.email = '';
      this.form.name = '';
      this.form.food = null;
      this.form.checked = [];
      /* Trick to reset/clear native browser form validation state */
      this.show = false;
      this.$nextTick(() => { this.show = true });
    }
  }
}
</script>
