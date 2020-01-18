**List Artists**
----
  Returns json data with an array of artists.

* **URL**

  `/wp-json/wp/v2/artist`

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `[ { "id": 440 ... }, { "id": 441 ... }  ... { "id": 445 ... } ]`
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```
    {
        "code": "rest_no_route",
        "message": "No route was found matching the URL and request method",
        "data": {
            "status": 404
        }
    }
    ```

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/wp-json/wp/v2/artist",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```

  **Show Artist**
----
  Returns json data about a single artist.

* **URL**

  /wp-json/wp/v2/artist/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  Filter artist by slug name

  `/wp-json/wp/v2/artist?slug=judas-priest`

  Filter artist by event id

  `/wp-json/wp/v2/artist?filter[meta_key]=event_artist&filter[meta_value]=442&filter[meta_compare]=LIKE`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```
    {
        "id": 438,
        "date": "2020-01-17T19:23:54",
        "date_gmt": "2020-01-17T19:23:54",
        "guid": {
            "rendered": "http://calacas.wp/?post_type=artist&#038;p=438"
        },
        "modified": "2020-01-17T19:32:20",
        "modified_gmt": "2020-01-17T19:32:20",
        "slug": "judas-priest",
        "status": "publish",
        "type": "artist",
        "link": "http://calacas.wp/artist/judas-priest/",
        "title": {
            "rendered": "Judas Priest"
        },
        "template": "",
        "acf": {
            "artist_photo": {
                "ID": 439,
                "id": 439,
                "title": "1280px-Judas_Priest_-_Wacken_Open_Air_2018_01",
                "filename": "1280px-Judas_Priest_-_Wacken_Open_Air_2018_01.jpg",
                "filesize": 226676,
                "url": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-1119x750.jpg",
                "link": "http://calacas.wp/artist/judas-priest/1280px-judas_priest_-_wacken_open_air_2018_01/",
                "alt": "",
                "author": "1",
                "description": "",
                "caption": "",
                "name": "1280px-judas_priest_-_wacken_open_air_2018_01",
                "status": "inherit",
                "uploaded_to": 438,
                "date": "2020-01-17 19:23:18",
                "modified": "2020-01-17 19:23:18",
                "menu_order": 0,
                "mime_type": "image/jpeg",
                "type": "image",
                "subtype": "jpeg",
                "icon": "http://calacas.wp/wp-includes/images/media/default.png",
                "width": 1119,
                "height": 750,
                "sizes": {
                    "thumbnail": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-150x150.jpg",
                    "thumbnail-width": 150,
                    "thumbnail-height": 150,
                    "medium": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-300x201.jpg",
                    "medium-width": 300,
                    "medium-height": 201,
                    "medium_large": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-768x515.jpg",
                    "medium_large-width": 768,
                    "medium_large-height": 515,
                    "large": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-1024x686.jpg",
                    "large-width": 1024,
                    "large-height": 686,
                    "1536x1536": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01.jpg",
                    "1536x1536-width": 1280,
                    "1536x1536-height": 858,
                    "2048x2048": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01.jpg",
                    "2048x2048-width": 1280,
                    "2048x2048-height": 858,
                    "wp-rig-featured": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-720x480.jpg",
                    "wp-rig-featured-width": 720,
                    "wp-rig-featured-height": 480,
                    "full": "http://calacas.wp/wp-content/uploads/2020/01/1280px-Judas_Priest_-_Wacken_Open_Air_2018_01-1119x750.jpg",
                    "full-width": 1119,
                    "full-height": 750
                }
            },
            "contact_info": {
                "email": "judas.priest@gmail.com",
                "phone": "987654321"
            },
            "event_artist": [
                442
            ],
            "additional_info": "Judas Priest are a heavy metal band that were formed in West Bromwich, England in 1969. However, they did not achieve major commercial success until 1980 with the release of their sixth album, “British Steel”. It featured the singles “Breaking The Law”, “United” and “Living After Midnight”. Rolling Stone ranked the album 3rd on list of \"100 Greatest Metal Albums of All Time\" in 2017. The band went on to win a Grammy in 2010 for Best Metal Performance and the Hall of Fame Award at the Kerrang! Awards in 2007. In total they have sold over 50 million copies of their albums. Judas Priest have performed at many festivals, including Live Aid, US Festival, Epicenter Festival, Welcome to Rockville, Download (UK, Madrid, Japan, Australia), Bloodstock Open Air, Wacken Open Air, Hills Of Rock, Rock Fest Barcelona, Hellfest, Graspop Metal Meeting, Firenze Rocks and Sweden Rock Festival."
        },
        "_links": {
            "self": [
                {
                    "href": "http://calacas.wp/wp-json/wp/v2/artist/438"
                }
            ],
            "collection": [
                {
                    "href": "http://calacas.wp/wp-json/wp/v2/artist"
                }
            ],
            "about": [
                {
                    "href": "http://calacas.wp/wp-json/wp/v2/types/artist"
                }
            ],
            "wp:attachment": [
                {
                    "href": "http://calacas.wp/wp-json/wp/v2/media?parent=438"
                }
            ],
            "curies": [
                {
                    "name": "wp",
                    "href": "https://api.w.org/{rel}",
                    "templated": true
                }
            ]
        }
    }
    ```
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```
    {
        "code": "rest_post_invalid_id",
        "message": "Invalid post ID.",
        "data": {
            "status": 404
        }
    }
    ```

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/wp-json/wp/v2/artist/1",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```