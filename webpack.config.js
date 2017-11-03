//import webpack.js based on env variable
module.exports = function(env) {
  return require(`./webpack.${env}.js`)
};
