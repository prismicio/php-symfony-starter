## Starter for Symfony PHP projects

This is a blank [Symfony](http://symfony.com) project that will connect to any [prismic.io](https://prismic.io) repository. It uses the prismic.io PHP development kit, and provide a few helpers to integrate with the Symfony framework.

> This is a starter project, you are encouraged to use it to bootstrap your own project, or as inspiration to understand how you can integrate the prismic.io developement kit with a Symfony project.

### How to start?

    curl -s http://getcomposer.org/installer | php --
    php composer.phar create-project prismic/symfony-starter php-symfony-starter
    cd php-symfony-starter
    sudo chmod -R 777 app/cache app/logs

Launch the application in your browser (the URL should be something like http://localhost/php-symfony-starter/web/app_dev.php/).

### Reporting an issue

Note that this starter project is almost entirely based on [the official prismic.io SymfonyBundle](https://github.com/prismicio/SymfonyBundle); please report any issue over there.

### Licence

This software is licensed under the Apache 2 license, quoted below.

Copyright 2013 Zengularity (http://www.zengularity.com).

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this project except in compliance with the License. You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0.

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
