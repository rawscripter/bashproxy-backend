<template>
  <div>
    <div id="login">
      <h1 class="title">Bash Proxy</h1>
      <button class="login-btn" @click="loginWithDiscord">
        <img class="discord_icon" src="/assets/login/discord_icon.png" alt="" />
        Login through discord
      </button>
      <div style="display: flex; flex-direction: row">
        <img
          class="snkr"
          style="transform: scaleX(-1); height: 120px; margin-top: 10px"
          src="/assets/sknrs/snkr1.png"
          alt=""
        />
        <img class="snkr" src="/assets/sknrs/snkr2.png" alt="" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  methods: {
    loginWithDiscord() {
      let url = `https://discord.com/api/oauth2/authorize?client_id=848990428590112788&redirect_uri=https%3A%2F%2Fdashboard.bashproxy.com%2Fdiscord%2Fcallback&response_type=token&scope=identify%20email`;
      // let url = `https://discord.com/api/oauth2/authorize?client_id=848990428590112788&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fdiscord%2Fcallback&response_type=token&scope=identify%20email`;
      window.location.href = url;
    },
  },
  mounted() {
    if (this.$store.state.isLoggedIn) {
      this.$router.push("/");
    }
  },
};
</script>

<style>
:root {
  --theme-dark: #2c2f33;
  --theme-blue: #7289da;
  --gray: #999999;
  --light-gray: #e6e6e6;
  --lightest-gray: #f8f8f8;
}

#app {
  height: 100vh !important;
  display: grid !important;
  margin: 0 !important;
}

#login {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  margin-top: 150px;
}

.title {
  font-size: 4rem;
  text-shadow: 0px 0px 20px var(--theme-blue);
  color: var(--lightest-gray);
}

.login-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  color: var(--theme-blue);
  background: var(--light-gray);
  font-size: 20px;
  width: 280px;
  height: 60px;
  margin-top: 50px;
  margin-bottom: 50px;
  cursor: pointer;
}

.login-btn:hover {
  background: var(--theme-blue);
  color: var(--light-gray);
  box-shadow: 0px 0px 10px var(--theme-blue);
}

button:focus {
  outline: none;
}

.discord_icon {
  width: 30px;
  margin-right: 10px;
}

.snkr {
  width: 180px;
}
</style>
