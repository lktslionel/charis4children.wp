# ABW

Audrey & Bastian's wedding website

## Development

### Requirements

This project requires : 

* Docker `18.06.1-ce or later`
* Docker-compose `1.22.0 or later`


### Getting started

For security reason and to prevent sensible data being include into the repo, you must provide the following values by adding the line below to a file at path: `$HOME/.envs/dev`

```shell
export ABW_DB_PASSWORD=<ENTER_A_VALUE>
export ABW_WORDPRESS_PASSWORD=<ENTER_ANOTHER_VALUE>'
```


The site is build with wordpress on a dockerized environment. In order to start working on the site, use the following command : 

```sh
source $HOME/.envs/dev &&\
  compose -p abw -f etc/docker/docker-compose.yml up --build -d
```

### Wordpress Theme

We bought our [site template](http://onelove.catanisthemes.com/) on themeforest site; and, we downloaded the theme content from there. The template is also available at [mega.nz/#!tAxSkArD](https://mega.nz/#!tAxSkArD). 

> Contact us to get the `encryption key` at `contact.ab.wedding+com/comm@gmail.com`

### Wordpress Plugins 

Below are the list of wordpress plugins we use: 

* Caldera Forms
* Caldera Form Google Spreadsheet 
