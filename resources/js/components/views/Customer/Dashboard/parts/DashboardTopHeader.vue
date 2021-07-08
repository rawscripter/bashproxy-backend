<template>
  <div class="section-button-area">
    <div class="btn-country">
      <form>
        <select v-model="formData.countryCode" name="cars" class="select">
          <option value="">Select Country</option>
          <option v-for="country in countryList" :key="country.code" :value="country.code">{{
            country.name
            }}
          </option>
        </select>
      </form>
    </div>
    <div class="btn-quantity">
      <!--      <input type="number" min="0" v-model="formData.quantity" step="1" class="select">-->

      <select v-model="formData.quantity" name="cars" class="select">
        <option value="0">Select Quantity</option>
        <option value="10">10</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="1000">1000</option>
        <option value="2000">2000</option>
        <option value="5000">5000</option>
      </select>

    </div>
    <div class="btn-generate">
      <button @click="generateProxy" class="btn btn-info" type="button">Generate</button>
    </div>
  </div>
</template>

<script>
import {PROXY_SERVER_TOKEN, PROXY_SERVER_BASE_URL} from "../../../../../Api";

const axios = require('axios').default;

export default {
  name: "DashboardTopHeader",
  data() {
    return {
      countryList: [
        {"code": "AT", "name": "Austria"},
        {"code": "AU", "name": "Australia"},
        {"code": "BE", "name": "Belgium"},
        {"code": "CA", "name": "Canada"}, {"code": "CZ", "name": "Czech Republic"}, {
          "code": "DE",
          "name": "Germany"
        }, {"code": "DK", "name": "Denmark"}, {"code": "ES", "name": "Spain"}, {
          "code": "FR",
          "name": "France"
        }, {"code": "GR", "name": "Greece"}, {"code": "HK", "name": "Hong Kong"}, {
          "code": "HU",
          "name": "Hungary"
        }, {"code": "IE", "name": "Ireland"}, {"code": "IT", "name": "Italy"}, {
          "code": "JP",
          "name": "Japan"
        }, {"code": "KR", "name": "South Korea"}, {"code": "MX", "name": "Mexico"}, {
          "code": "NL",
          "name": "Netherlands"
        }, {"code": "NO", "name": "Norway"}, {"code": "NZ", "name": "New Zealand"}, {
          "code": "SE",
          "name": "Sweden"
        }, {"code": "SG", "name": "Singapore"}, {"code": "US", "name": "United States"}
      ],
      formData: {
        countryCode: '',
        quantity: 0
      }
    }
  },
  methods: {
    generateProxy() {
      if (this.formData.countryCode === '') {
        this.$toast.error("Please Select a Country.");
        return;
      }
      if (this.formData.quantity == 0) {
        this.$toast.error('Quantity can\'t be 0');
        return;
      }
      this.$store.state.isLoading = true;
      let user = this.$store.state.proxyUser.user_id;
      let country_code = this.formData.countryCode;
      let quantity = this.formData.quantity;
      const headers = {
        'Authorization': PROXY_SERVER_TOKEN
      }
      axios.post(`${PROXY_SERVER_BASE_URL}/user/proxy?userID=${user}&proxyCount=${quantity}&countryCode=${country_code}`, {}, {
        headers
      })
          .then(response => {
            this.$store.commit('SET_USER_PROXY_TEXT_VERSION', response.data);
            let proxy = response.data.split("\n");
            this.$store.commit('SET_USER_PROXY', proxy);
            this.$toast.success("Proxy generated.");
            this.$store.state.isLoading = false;
          })
          .catch(err => {
            this.$store.state.isLoading = false;
            console.log(err)
          })
    }
  }
}
</script>

<style scoped>
input.select {
  padding: 6px;
  background: #242528;
  box-shadow: none !important;
  border: 1px solid #c3c6c5;
  color: #c3c6c5;
}

input::placeholder {
  color: #c3c6c5;
}
</style>
