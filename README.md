<!-- PROJECT SHIELDS -->
<!--
*** This template uses markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

[![Contributors][contributors-shield]][contributors-url] [![Forks][forks-shield]][forks-url] [![Stargazers][stars-shield]][stars-url] [![Issues][issues-shield]][issues-url]

<!-- ABOUT THE PROJECT -->

## About The Project

[![Product Name Screen Shot][product-screenshot]](https://example.com)

This project was realized during my training as a web applications developer for a fictitious company. It comes from a [french online tutorial provided by Développeur Musclé](https://www.youtube.com/playlist?list=PLUiuGjup8Vg5t20nu7aaJDnbHlhzXbbuN).

### Built With

- HTML 5, CSS 3, PHP 8
- Symfony 7, Bootstrap 5
- Git, Github
- VS Code
- Love :)

<!-- GETTING STARTED -->

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

- Git
- MySQL, MariaDB, Postgresql or SQLite
- Symfony CLI

### Installation

1. Clone the repo
2. Create a .env.dev.local file and customize it with your DATABASE_URL variable (have a look in the .env file and customize the value according your Database system and your database username, password and server version)
3. Create the database by typing in your terminal:

```sh
cd to/the/project/directory/path
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4. Import the data from the fixtures by typing in your terminal:

```sh
php bin/console doctrine:fixtures:load
```

5. Launch the server:

```sh
symfony serve -d
```

6. Open the https://127.0.0.1:8000 address in your favorite internet browser (or another port that 8000 if the Symfony server gives you another port at starting)

<!-- USAGE EXAMPLES -->
<!--
## Usage

You can use the web application as a default visiter at the root address.
You can use it as an administrator using the /admin address. In this administrator area, you'll be able to add new properties and edit and delete existing ones.
-->

<!-- CONTACT -->

## Contact

Christophe Simon: [personnal website](https://www.csimon.info)

Project Link: [https://github.com/christophe-simon/les-recettes-de-marinette](https://github.com/christophe-simon/les-recettes-de-marinette)

<!-- ACKNOWLEDGEMENTS -->

## Acknowledgements

- This readme version is a customized version of this [github repository](https://github.com/NicolasBrondin/basic-readme-template) by NicolasBrondin

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[contributors-shield]: https://img.shields.io/github/contributors/christophe-simon/basic-readme-template.svg?style=flat-square
[contributors-url]: https://github.com/christophe-simon/basic-readme-template/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/christophe-simon/basic-readme-template.svg?style=flat-square
[forks-url]: https://github.com/christophe-simon/basic-readme-template/network/members
[stars-shield]: https://img.shields.io/github/stars/christophe-simon/basic-readme-template.svg?style=flat-square
[stars-url]: https://github.com/christophe-simon/basic-readme-template/stargazers
[issues-shield]: https://img.shields.io/github/issues/christophe-simon/basic-readme-template.svg?style=flat-square
[issues-url]: https://github.com/christophe-simon/basic-readme-template/issues
[license-shield]: https://img.shields.io/github/license/christophe-simon/basic-readme-template.svg?style=flat-square
[license-url]: https://github.com/christophe-simon/basic-readme-template/blob/master/LICENSE.txt
[product-screenshot]: docs/cover.jpg
