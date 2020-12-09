FollowDem
=========

Cartographic web application to track moving objects equipped with a GPS.

This application is used by the Ecrins national Park to follow ibex : `<http://bouquetins.ecrins-parcnational.fr>`_

.. image :: docs/img/screenshot-bouquetins-pne.jpg
    :target: http://bouquetins.ecrins-parcnational.fr

Based on Followdem-admin (https://github.com/PnEcrins/FollowDem-admin) to install before to create the PostgreSQL database, manage devices, animals and attributes. It also allows to import massive GPS data.

French version of this presentation : `<https://github.com/PnEcrins/FollowDem/blob/master/README-fr.rst>`_
    
Technologies
------------

- Languages : PHP, HTML, JS, CSS
- Database : PostgreSQL ou MySQL / PDO
- Server : Debian ou Ubuntu
- Carto framework : `Leaflet <http://leafletjs.com>`_
- CSS framework : `Bootstrap <http://getbootstrap.com>`_
- Template : `Bootleaf <https://github.com/bmcbride/bootleaf>`_
- Cache and template management : `Smarty <http://www.smarty.net>`_
- Base maps : Geoportail, OpenStreetMap, Google Maps, WMS

Presentation
------------

**General principles** : 

This application allows to track position of several objects (animals, bus...) equipped with a GPS.

Each object has an ID. They all transmit their GPS position to a satellite at regular intervals.

Then the application download these GPS positions to upload them in the MySQL database. For that, a TXT file is sent to an electronic mailbox for each object and each position. 

A task (``import_imap_csv`` in file ``/classes/controler/controler.class.php``) is executing these steps : 

- Connecting to this mailbox and extracting the TXT files attached to emails
- Copying these TXT files in the directory ``tmp/csv``
- Deleting emails once TXT files are copied on FollowDem server
- Importing new positions of all objects (if these ones are already in the database with a common ID) in a CSV file (``/csv/tracked_objects.csv``)
- Deleting the TXT temporaries TXT files once their content has been included in the CSV file
- Importing new positions in the MySQL database from the file ``/csv/tracked_objects.csv``
- Emptying file ``/csv/tracked_objects.csv``

This task can be executed manually or with a CRON launched automatically and regulary. 

Other ways to fill this CSV could be considered : 

- Directly fill the CSV file (automatically or manually)
- Import TXT files in directory ``tmp/csv`` without connecting to a mailbox

**Demonstration and features**

Try it at `<http://bouquetins.ecrins-parcnational.fr>`_.

It includes a list of tracked objects, the map of tracked objects, a tool to select data duration. 

When you click on an objects on map, click on "Voir le parcours" to show his recent travel. Then you can change duration (last 15, 30, 60, 90, 120... days). 

You can also click on one position to view the day and hour, altitude and temperature. 

All datas are collected in real-time and automatically from GPS positions of each ibex. 

Our aim with this application was to do something very easy to use for everyone (schools, tourists, scientifics, curious...) that want to understand how ibex are moving. 

We have another internal tool with more functionalities for our scientific program. 

We learnt a lot with this GPS program. Here is just an example of an ibex that travelled to Italia : http://www.ecrins-parcnational.fr/actualite/un-bouquetin-des-cerces-en-italie

Scientific program explanations : http://www.ecrins-parcnational.fr/actualite/des-bouquetins-geolocalises

Installation
------------

Documentation :  `<http://followdem.rtfd.org>`_ (French)

Authors
-------

Parc national des Ecrins

- Fabien Selles
- Thibault Romanin
- Gil Deluermoz
- Camille Monchicourt

Natural Solutions

Licence
-------

* OpenSource - GPLv3
* Copyright (c) 2015-2020 - Parc National des Écrins


.. image:: http://geonature.fr/img/logo-pne.jpg
    :target: http://www.ecrins-parcnational.fr
