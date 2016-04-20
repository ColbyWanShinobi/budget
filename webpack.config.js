
var path = require('path')
var webpack = require('webpack')

module.exports = {

    resolve: {
        root: [
            path.join(__dirname, 'webpack'),
        ],
    },

    entry: [
        'bootstrap',
        'font-awesome/css/font-awesome.css',
        'scripts/init-vue.js',
        'scripts/init-vue-components.js',
        'styles/bootstrap.less',
        'scripts/init-vue-router.js',
    ],

    output: {
        path: path.join(__dirname, 'public', 'assets'),
        filename: 'build.js',
        publicPath: "/assets/",
    },

    module: {
        loaders: [
            {
                test: /\.vue$/,
                loader: 'vue',
            },
            {
                test: /\.css$/,
                loaders: ['style', 'css'],
            },
            {
                test: /\.less$/,
                loaders: ['style', 'css', 'less'],
            },
            {
                test: /\.(ttf|eot|svg|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader: "file",
                query: {
                    name: "[name].[ext]",
                },
            },
        ],
    },

    plugins: [
        new webpack.ProvidePlugin({
            jQuery: "jquery",
            Vue: "vue",
            VueRouter: "vue-router",
        }),
    ],

}
