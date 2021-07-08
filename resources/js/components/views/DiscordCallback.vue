<template>
  <div id="spinner">
    <atom-spinner :animation-duration="1000" :size="60" color="#fff" />
  </div>
</template>

<script>
import { AtomSpinner } from "epic-spinners";

export default {
  name: "DiscordCallback",
  components: {
    AtomSpinner,
  },
  data() {
    return {
      code: null,
    };
  },
  mounted() {
    this.processUserLogin();
  },
  created() {
    if (this.$store.state.isLoggedIn) {
      this.$router.push("/");
    }
  },
  methods: {
    processUserLogin() {
      window.onload = () => {
        const fragment = new URLSearchParams(window.location.hash.slice(1));
        const [accessToken, tokenType] = [
          fragment.get("access_token"),
          fragment.get("token_type"),
        ];

        if (!accessToken) {
          this.$router.push("/login");
        }

        fetch("https://discord.com/api/users/@me", {
          headers: {
            authorization: `${tokenType} ${accessToken}`,
          },
        })
          .then((result) => result.json())
          .then((response) => {
            this.$store.commit("LOGIN_OR_REGISTER_USER", response);
          })
          .catch(console.error);
      };
    },
  },
};
</script>

<style>
div#spinner {
  position: absolute;
  background: #12121247;
  width: 100%;
  height: 100%;
  display: grid;
  align-items: center;
  text-align: center;
  justify-content: center;
  z-index: 9999 !important;
}
</style>
