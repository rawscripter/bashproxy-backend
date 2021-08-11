<template>
  <div class="container-fluid m-0 p-0">
    <div id="spinner" v-if="this.isLoading">
      <atom-spinner
          :animation-duration="1000"
          :size="60"
          color="#fff"
      />
    </div>
    <div class="row m-0 p-0">
      <Sidebar></Sidebar>
      <div class="col-md-10 class-top-up-area">
        <div class="row">
          <div class="col-6 m-auto">
            <div class="product-area">
              <div class="product">
                <div class="product-title">
                  <h3><Strong>{{ planName }}</Strong></h3>
                </div>
                <div class="product-price">
                  <span class="currency-sign">$</span> <span class="amount">{{ planPrice }}</span>
                </div>

                <div class="product-details">
                  <ul>
                    <li>70+ million IPs globally</li>
                    <li>30 Day Validity</li>
                    <li>20+ supporting countries</li>
                  </ul>
                </div>

                <div class="product-variation">
                  <select v-model="selectedPlan" name="cars" class="select">
                    <option v-for="(plan) in dataPlans" :key="plan.id" :value="plan.id">
                      ${{ plan.price }}/{{ plan.quantity }}
                    </option>
                  </select>
                </div>

                <div class="text-center mt-3">
                  <input v-model="discountCode" v-if="showDiscountCode" type="text"
                         class="coupon-code"
                         placeholder="Discount Code">
                  <p v-if="!showDiscountCode" @click="showDiscountCode = true"
                     class="mb-0 show-discount-code">Have Discount
                    Code?</p>
                  <p v-if="showDiscountCode"
                     @click="applyDiscountCode"
                     class="mb-0 show-discount-code mt-1">Apply Discount
                    Code</p>
                </div>
                <div class="checkout-btn">
                  <div @click="submit" class="btn btn-checkout">
                    Purchase Now
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import 'bootstrap/dist/css/bootstrap.css'
import Sidebar from "../layouts/Sidebar";
import '../Dashboard/dashboard.css'
import {StripeCheckout} from '@vue-stripe/vue-stripe';
import {SITE_BASE_URL} from "../../../../Api";
import {AtomSpinner} from 'epic-spinners'

export default {
  name: "Topup",

  data() {
    return {
      isLoading: false,
      showDiscountCode: false,
      discount: 0,
      discountPercentage: 0,
      discountCode: '',
      dataPlans: [
        {
          id: 1,
          price: 10.00,
          quantity: '1.00G',
          data: '950',
          price_id: 'price_1JGVvFFUYXxPczkJbQfYvDdL',
        },
        {
          id: 2,
          price: 20.00,
          quantity: '2.00G',
          data: '1900',
          price_id: 'price_1JGVwrFUYXxPczkJVSm7Dmwn',
        },
        {
          id: 3,
          price: 45.00,
          quantity: '5.00G',
          data: '4750',
          price_id: 'price_1JGW7CFUYXxPczkJ9MNwoa9f',

        }, {
          id: 4,
          price: 80.00,
          quantity: '10.00G',
          data: '9500',
          price_id: 'price_1JGW7cFUYXxPczkJaPlKZ08Y',

        }, {
          id: 5,
          price: 150.00,
          quantity: '20.00G',
          data: '19000',
          price_id: 'price_1JGW7xFUYXxPczkJupGpteY5',

        }, {
          id: 6,
          price: 350.00,
          quantity: '40.00G',
          data: '38000',
          price_id: 'price_1JGW8SFUYXxPczkJPDcI2mrD',

        }
      ],
      selectedPlan: 1
    }
  },
  components: {
    Sidebar,
    AtomSpinner
  },
  created() {
    this.isLoading = true;
  },

  methods: {

    callPaymentWindow(res) {
      let stripe = Stripe(res.data.public_key);
      stripe.redirectToCheckout({
        sessionId: res.data.session_id
      }).then(res => {
        console.log(res)
      });
    },
    submit() {
      this.isLoading = true;
      let planIndex = this.dataPlans.findIndex(plan => plan.id === this.selectedPlan);
      let plan = this.dataPlans[planIndex];

      axios.post(`${SITE_BASE_URL}/api/payment/session/create`, {
        coupon_code: this.discountCode,
        quantity: plan.data,
        user: this.$store.state.user.id,
        price_id: plan.price_id
      })
          .then(res => {
            if (res.data.success) {
              this.callPaymentWindow(res);
            } else {
              this.isLoading = false;
              this.$toast.error(res.data.message);
            }

          })
          .catch(err => {
            this.$toast.error('Server Error');
            this.isLoading = false;
            console.log(err)
          })
      // You will be redirected to Stripe's secure checkout page
    },
    applyDiscountCode() {
      this.isLoading = true;

      axios.post(`${SITE_BASE_URL}/api/coupon/check`, {
        discountCode: this.discountCode,
      })
          .then(res => {
            if (res.data.is_valid) {
              this.discount = res.data.amount_off;
              this.discountPercentage = res.data.save_percentage;
              this.$toast.success('Discount Code Applied');
            } else {
              this.discount = 0;
              this.discountPercentage = 0;
              this.$toast.error(res.data.message);
            }
            this.isLoading = false;
          }).catch(err => {
        this.$toast.error('Server Error');
        this.isLoading = false;
        console.log(err)
      })
    }
  },
  mounted() {
    this.isLoading = false;
  },
  computed: {
    planName() {
      let planIndex = this.dataPlans.findIndex(plan => plan.id === this.selectedPlan);
      return `Plan ${this.dataPlans[planIndex].quantity}`;
    },
    planPrice() {
      let planIndex = this.dataPlans.findIndex(plan => plan.id === this.selectedPlan);
      let finalPrice = this.dataPlans[planIndex].price;
      if (this.discount > 0) {
        finalPrice = finalPrice - this.discount;
      }
      if (this.discountPercentage > 0) {
        finalPrice = (this.discountPercentage / 100) * finalPrice;
      }
      return finalPrice.toFixed(2)
    }
  }
}
</script>

<style scoped>
* {
  font-family: 'Nunito', sans-serif;
}

div#spinner {
  position: absolute;
  background: #12121247;
  width: 100%;
  height: 100vh;
  display: grid;
  align-items: center;
  text-align: center;
  justify-content: center;
  z-index: 9999 !important;
}

.class-top-up-area {
  min-height: 100vh;
  display: grid;
}

.product {
  width: 400px;
  border: 1px solid #494949;
  padding: 30px 30px;
  margin: 0 auto !important;
  border-radius: 10px;
}

.product-title h3 {
  font-size: 40px !important;
  color: #d7d7d7;
}

.product-price {
  margin-bottom: 20px;
  font-size: 34px !important;
  color: #d7d7d7;
  font-weight: bold;
}

span.currency-sign {
  font-size: 15px;
  margin-right: -7px;
}

.product-details li {
  list-style: none;
  padding: 10px;
  border: 1px solid #2b2b2b;
  color: #ccc;
  margin: 0;
  border-radius: 10px;
  margin-bottom: 10px;
}

.product-details ul {
  padding: 0;
  margin: 0;
  margin-bottom: 25px;
}

select {
  border-color: #686868 !important;
}

.btn-checkout {
  margin-top: 25px;
  padding: 10px;
  background: #29292b;
  width: 100%;
  color: #fff;
  font-weight: bold;
  font-size: 17px;
}

input.coupon-code {
  padding: 8px;
  width: 100%;
  background: transparent;
  border: 1px solid #878787;
  border-radius: 4px;
  color: #ccc;
  font-weight: bold;
}

.show-discount-code {
  color: #ccc;
  text-decoration: underline;
  cursor: pointer;
}
</style>
