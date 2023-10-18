<?php
/*
Plugin Name: testplugin Test
Description: this class/plugin.
Author: Muhammad Rizki
*/

class Test
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_shortcode('test_shortcode', [$this, "testShortcode"]);
        // add_action('init', [$this, "testShortcode"]);
    }

    public function testShortcode()
    {
        
        $data = $this->fetchData();
        $this->saveData($data);

        $argPost = [
            'numberposts'      => -1,
            'post_type'        => 'post',
        ];

        $posts = get_posts($argPost);

        foreach($posts as $post) {
            echo "title : $post->post_title <br>";
            echo "content/url : $post->post_content <br>";
            echo "<br>";
        }

  
    }

    public function fetchData() 
    {
        $url = "https://pokeapi.co/api/v2/pokemon/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);

    }

    public function saveData($data)
    {

        foreach($data['results'] as $dt) {
            $post = [
                'post_title'    => wp_strip_all_tags($dt['name'] ),
                'post_content'  => sanitize_url($dt['url']),
                'post_type '    => 'post', //    change this to your custom post type
                'post_status'   => 'publish',
            ];
            $post_id = wp_insert_post( $post );
        }

    }
}

new Test();