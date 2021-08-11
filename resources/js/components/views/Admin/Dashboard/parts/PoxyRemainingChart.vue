<template>
    <div class="col-md-12 col-xl-4">
        <div class="data-remaing-section m-auto">

            <radial-progress-bar :diameter="200"
                                 :startColor="'#00FF00'"
                                 :fps="90"
                                 :stopColor="'#FF6347'"
                                 :completed-steps="usedPackage"
                                 :total-steps="totalPackage">
                <p class="m-0 font-weight-bolder">Total: {{ totalPackage / 1000 }}G</p>
                <p class="m-0 font-weight-bolder">Used: {{ usedPackage }}</p>
            </radial-progress-bar>
            <h3 class="font-weight-bolder">Data Remaining: {{ remainingPackage }}</h3>
            <router-link tag="a" class="text-white font-weight-bolder" to="/top-up">
                TOP UP NOW
            </router-link>
        </div>
    </div>

</template>

<script>

import RadialProgressBar from 'vue-radial-progress'

export default {
    name: "PoxyRemainingChart",
    props: ['userData'],
    components: {
        RadialProgressBar
    },
    data() {
        return {
            usedPackage: 0,
            totalPackage: 0,
            remainingPackage: 0
        }
    },
    watch: {
        'userData.totalPackage'(val) {
            this.totalPackage = parseInt(val);
        },
        'userData.usedPackage'(val) {
            this.usedPackage = parseInt(val);
        },
        'userData.remainingPackage'(val) {
            this.remainingPackage = parseInt(val);
        }
    }
}
</script>

<style scoped>
.radial-progress-container {
    margin: 0 auto;
    color: #CBCDCC;
    font-weight: bold;
}
</style>
