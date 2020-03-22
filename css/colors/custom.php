<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

echo "    
<style>

html {
    
    /* Theme Colors */
    --main-theme-color: " . CUSTOM_THEME_PRIMARY . ";
    --secondary-theme-color: " . CUSTOM_THEME_SECONDARY . ";
}
.theme-color {
  color: var(--main-theme-color);
}
.navbar-header {
  background: var(--main-theme-color);
}
.right-sidebar .rpanel-title {
  background: var(--main-theme-color);
}
.bg-title .breadcrumb .active {
  color: var(--main-theme-color);
}
#side-menu li a {
  color: var(--secondary-theme-color);
}
#side-menu li a {
  color: var(--secondary-theme-color);
}
#side-menu > li > a.active {
  background: var(--main-theme-color);
}
#side-menu ul > li > a:hover {
  color: var(--main-theme-color);
}
#side-menu ul > li > a.active {
  color: var(--main-theme-color);
}
.user-profile .user-pro-body .u-dropdown {
  color: var(--secondary-theme-color);
}
.color-button,
.color-button.disabled {
    color: var(--main-theme-color) !important;
    border: 1px solid var(--main-theme-color);
}
.color-button:hover,
.color-button.disabled:hover,
.color-button:focus,
.color-button.disabled:focus,
.color-button.focus,
.color-button.disabled.focus {
    border: 1px solid var(--main-theme-color);
    background: var(--main-theme-color);
}
.bg-theme {
    background-color: var(--main-theme-color) !important;
}
.bg-theme-dark {
    background-color: var(--main-theme-color) !important;
}
.btn-custom {
    background: var(--main-theme-color);
    border: 1px solid var(--main-theme-color);
}
.btn-custom:hover {
    background: var(--main-theme-color);
    color: var(--white);
    border: 1px solid var(--main-theme-color);
}
.customtab li.active a,
.customtab li.active a:hover,
.customtab li.active a:focus {
    border-bottom: 2px solid var(--main-theme-color);
    color: var(--main-theme-color);
}
.tabs-vertical li.active a,
.tabs-vertical li.active a:hover,
.tabs-vertical li.active a:focus {
    background: var(--main-theme-color);
    border-right: 2px solid var(--main-theme-color);
}
.nav-pills > li.active > a,
.nav-pills > li.active > a:focus,
.nav-pills > li.active > a:hover {
    background: var(--main-theme-color);
}
.table tbody tr.advance-table-row.active,
.fc-button {
  border-color: var(--main-theme-color);
}
.manage-users .tabs-style-iconbox nav {
  background: var(--main-theme-color);
}
.manage-users .tabs-style-iconbox nav li.tab-current a {
  background: var(--main-theme-color);
}
.manage-users .tabs-style-iconbox nav li.tab-current a:after {
  border-top-color: var(--main-theme-color);
}
.panel-themecolor,
.panel-theme {
  border-color: var(--main-theme-color);
}
.panel-themecolor .panel-heading,
.panel-theme .panel-heading {
  border-color: var(--main-theme-color);
  background-color: var(--main-theme-color);
}
    </style>"; ?>