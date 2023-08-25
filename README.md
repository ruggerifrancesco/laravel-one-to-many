<p align="center">
<a href="https://getbootstrap.com" target="_blank"><img src="https://miro.medium.com/v2/resize:fit:400/1*onZhQJU7A3ab6V1sHfMRkQ.jpeg" height="150"></a>
    <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="150"></a>
<a href="https://laravel.com" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/Sass_Logo_Color.svg/1200px-Sass_Logo_Color.svg.png" height="150"></a>

</p>

# Template for a Laravel 10.x + SCSS + Boostrap 5.x
Template to generate a new standard and simple project using Laravel 10.x, Bootstrap 5.x and SCSS (SASS with SCSS Syntax).

## Steps to build another template just like this one:
- Enter the desired project folder 
- Install the needed package `composer require laravel/ui`
- Apply the new auth scaffolding using bootstrap and laravel/ui: `php artisan ui bootstrap --auth`
- Add to `resources/app/js` this block of code to allow the correct renderization of our images

        import.meta.glob([
            '../img/**'
        ])

- Run `npm i` and
    - Configure correctly the `.env` file
    - Run `php artisan migrate` 
    - Run on two separeted terminals:
        - run `npm run dev` to build iteratively our front-end packages and code
        - run `php artisan serve` to build iteratively our back-end packages and code

- ## Addionals
    - Edit `vite.config.js` file:

            export default defineConfig({
                plugins: [
                    laravel({
                        input: [
                        'resources/scss/app.scss',
                        'resources/js/app.js',
                    ],
                    refresh: true
                }),
                ],
                resolve: {
                    alias: {
                        '~resources' : '/resources/',
                    }
                }
            });
    - Remove POSTCSS from our application `npm remove postcss`
    - Remove css folder from resources

## Steps to use this project correctly:
- Open this repository and click on  `Use this template ---> Create a new repository`
- Clone the repository wherever you want to develop, e.g. `VS Code`, `VSCodium`, ecc.
- **Open** the cloned folder with a `terminal`
- Copy and paste the `.env.example` file and rename it into `.env` **without removing the `env.example` file**
- Run `composer install` to install all our composer packages
- Run `php artisan key:generate` to generate our custom application key
- Run `npm i` to install all our npm packages
- Run on two separeted terminals:
    - run `npm run dev` to build iteratively our front-end packages and code
    - run `php artisan serve` to build iteratively our back-end packages and code
- Start changing the world with your oustanding code!
