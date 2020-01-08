const VueLoaderPlugin = require('vue-loader/lib/plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');
module.exports = {
    // devtool : 'cheap-module-source-map',
    entry : './resources/js/app.js',
    output : {
        path : path.resolve(__dirname, 'public/js'),
        filename : 'app.js'
    },
    resolve:{
        alias:{
            'vue$' : 'vue/dist/vue.esm.js'
        },
        extensions: ['*', '.js', '.vue', '.json']
    },
    module:{
        rules : [
        
            {
                test :/\.vue$/,
                loader: 'vue-loader'
            },            
            {
                test : /\.js$/,
                exclude : /(node_modules|bower_components)/,
                use:{
                    loader : 'babel-loader',
                    options :{
                        presets :['@babel/preset-env'],
                        plugins: ['@babel/plugin-transform-runtime']
                    }
                }
            },
            {
                test : /\.css$/,
                use :[
                    process.env.NODE_ENV !== 'production'
                    ? 'vue-style-loader'
                    : MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            },
            {
                test: /\.(gif|png|jpe?g|svg|webp)$/,
                use: [
                    {
                        loader:'file-loader',
                        options : {
                            name : '[name].[ext]',
                            outputPath : '../images/',
                            useRelativePath : false
                        }
                    },
                    {
                        loader: 'image-webpack-loader',
                        options: {
                            mozjpeg: {
                            progressive: true,
                            quality: 65
                            },
                            // optipng.enabled: false will disable optipng
                            optipng: {
                            enabled: false,
                            },
                            pngquant: {
                            quality: [0.65, 0.90],
                            speed: 4
                            },
                            gifsicle: {
                            interlaced: false,
                            },
                            // the webp option will enable WEBP
                            webp: {
                            quality: 75
                            }
                        }
                    }
                  
                ],
            },
             
        ]
    },
    plugins:[
        new VueLoaderPlugin(),
        // Esta parte no es casi necesario por lo que los estilos css lo compilara VUE bajo Javascript 
        // pero en el caso si queremos tener un css aperte, agregamos esta parte
        new MiniCssExtractPlugin({
            filename : '../css/app.css'
        })
    ]
}