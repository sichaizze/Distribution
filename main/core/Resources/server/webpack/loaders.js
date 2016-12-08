const paths = require('./paths')
const fs = require('fs')

/**
 * Transpiles es6 and jsx files with babel.
 */
 const babel = () => {
   return {
     test: /\.jsx?$/,
     exclude: /(node_modules|packages)/,
     loader: 'babel',
     query: {
       cacheDirectory: true,
       presets: ['es2015', 'react'],
       plugins: ['transform-runtime']
     }
   }
 }

/**
 * Returns the contents of HTML files as plain strings.
 */
 const rawHtml = () => {
   return {
     test: /\.html$/,
     loader: 'raw'
   }
 }

/**
 * NOTE: do we still need this now that jquery has been moved to externals?
 *
 * Disables AMD for jQuery UI modules. The reason is that these modules try to
 * load jQuery via AMD first but get a version of jQuery which isn't the one
 * made globally available, causing several issues. This loader could probably
 * be removed when jQuery is required only through module imports.
 */
 const jqueryUiNoAmd = () => {
   return {
     test: /jquery-ui/,
     loader: 'imports?define=>false'
   }
 }

/**
 * Enables css files imports.
 */
 const css = () => {
   return {
     test: /\.css$/,
     loader: 'style!css'
   }
 }

/**
 * Enables fonts files imports.
 */
 const font = () => {
   return {
     test: /\.(eot|svg|ttf|woff|woff2)$/,
     loader: 'url-loader?limit=100000'
   }
 }

/**
 * Encodes small images as base64 URIs.
 */
 const imageUris = () => {
   return {
     test: /\.(jpe?g|png|gif|svg)$/,
     loader: 'url?limit=25000'
   }
 }

/**
 * Loads modernizr configuration.
 *
 * @see https://github.com/peerigon/modernizr-loader
 */
 const modernizr = () => {
   return {
     test: /\.modernizrrc$/,
     loader: 'modernizr'
   }
 }

 const loadConfig = () => {
   return {
     test: /bundle-configs/,
     loader: 'raw-loader!./dist/plugins-config'
   }
 }

 const tinymceImport = () => {
   return {
     test: require.resolve(paths.bower() + '/tinymce/tinymce'),
     loaders: [
       'imports?this=>window',
       'exports?window.tinymce'
     ]
   }
 }

 const angularImport = () => {
   var vendorFile = paths.root() + '/webpack-vendors.json'
   if (fs.existsSync(vendorFile)) {
       const vendors = JSON.parse(fs.readFileSync(vendorFile, 'utf8'))
       const ang = paths.output() + '/' + vendors['angular']['js']
       if (fs.existsSync(ang)) {
           return {
             test: ang,
             loaders: [
               'imports?this=>window',
               'exports?window.angular'
             ]
           }
       }
   }

   return {
     test:  /[\/]angular\.js$/,
     loaders: [
       'imports?this=>window',
       'exports?window.angular'
     ]
   }
 }

 const tinymceWrapper = () => {
   return {
     test: /tinymce\/(themes|plugins)\//,
     loaders: [
       'imports?this=>window'
     ]
   }
 }

 const tinymceJquery = () => {
   return {
     test: /tinymce\/tinymce\.jquery\.js/,
     loader: 'imports?document=>window.document,this=>window!exports?window.tinymce'
   }
 }

 module.exports = {
   babel,
   loadConfig,
   rawHtml,
   jqueryUiNoAmd,
   css,
   font,
   imageUris,
   tinymceImport,
   tinymceWrapper,
   tinymceJquery,
   modernizr,
   angularImport
 }