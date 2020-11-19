module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],
  devServer: {
    proxy: {
      '^/api/': {
        target: 'http://config.gkta.ru',
        changeOrigin: true, // so CORS doesn't bite us. 
      }
    }
  }
}