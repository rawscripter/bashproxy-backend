<template>
  <div class="col-md-12 col-xl-8">
    <div class="midel-wraper">
      <!-- <h3 class="text-center">No Results</h3> -->
      <!-- table  -->
      <div class="table-responsive custom-table-responsive">
        <table class="table custom-table">
          <thead>
          <tr>
            <th scope="col">Proxy List</th>
          </tr>
          </thead>
          <tbody>
          <tr scope="row" v-for="(proxy) in pageOfItems" :key="proxy">
            <td class="custom-cursor">
              <copy-to-clipboard :text="proxy" @copy="handleCopy">
                {{ proxy }}
              </copy-to-clipboard>
            </td>
          </tr>

          <tr v-if="pageOfItems.length < 1" style="border: none !important;">
            <td style="text-align: center">
              No Data Found
            </td>
          </tr>
          </tbody>
        </table>

      </div>
      <jw-pagination :pageSize="5" :items="this.$store.state.proxy" @changePage="onChangePage"></jw-pagination>

      <!-- Table  -->
    </div>
    <div class="midle-btn mt-5 mb-5">
      <copy-to-clipboard :text="this.$store.state.proxyTextVersion" @copy="handleCopy">
        <button class="btn btn-info mr-3" type="button"><i class="fa fa-copy"></i> Copy All Proxy</button>
      </copy-to-clipboard>
      <button @click="downloadPoxy" class="btn btn-info mt1" type="button"><i class="fa fa-download"></i> Download All
        Proxy
      </button>

    </div>
  </div>
</template>

<script>

import JwPagination from 'jw-vue-pagination';
import CopyToClipboard from 'vue-copy-to-clipboard'

export default {
  name: "PoxyTable",
  components: {
    JwPagination,
    CopyToClipboard,
  },
  data() {
    return {
      pageOfItems: []
    }
  },
  methods: {
    handleCopy(result) {
      if (!this.$store.state.proxyTextVersion.length > 0) {
        this.$toast.error("No Data Found.");
        return;
      }
      this.$toast.success("Proxy copied to clipboard.");
    },
    onChangePage(pageOfItems) {
      // update page of items
      this.pageOfItems = pageOfItems;
    },
    downloadPoxy() {
      this.download("proxy.txt", this.$store.state.proxyTextVersion);
    },
    download(filename, text) {
      if (!this.$store.state.proxyTextVersion.length > 0) {
        this.$toast.error("No Data Found.");
        return;
      }
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
      element.setAttribute('download', filename);
      element.style.display = 'none';
      document.body.appendChild(element);
      element.click();
      document.body.removeChild(element);
      this.$toast.success("Proxy downloaded.");
    }
  },
}
</script>

<style>
table, td, tr {
  text-align: left;
}

li.page-item.page-number.active a {
  color: #29292b !important;
  background: white !important;
}

.custom-cursor {
  cursor: copy;
}

.midel-wraper {
  background-color: #29292B;
  padding: 10px;
  min-height: 445px;
}

.border-0 {
  border: none !important;
}
</style>