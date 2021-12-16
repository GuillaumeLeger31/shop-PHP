const vue = new Vue({
  data: () => {
    return {
      products: [],
      searchKey: ""
    }
  },
  computed: {
    search() {
      return this.products.filter((product) => {
        return product.title.toLowerCase().includes(this.searchKey.toLowerCase())
      })
    }
  },
  mounted() {
    axios.get("getData.php")
      .then((res) => res.data)
      .then((res) => {
      this.products = res;
      console.log(this.products);
      })
  }
}).$mount("#searchbar");
  