# Githubviewer - Drupal 8 Dummycode
It just returns some data from github and only demonstrates some Drupal 8 concepts (Services, etc)

## Important:
This code is not supposed to be used in a productive environment.

## Usage
If you want to make more than 60 requests to github, you need to set your github credentials:
/admin/config/system/githubviewer-admin

## Get JSON data
/githubhistory/<githubowner>/<githubrepositoryname>/<githubusername>


## Use it as a block
A configurable block is available under 
/admin/structure/block

## Set defaults
In githubviewer.settings.yml you can set a default github repository and user