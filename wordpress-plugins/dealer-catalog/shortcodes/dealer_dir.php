<select name="city" id="city">
    <option id="-1">Все города</option>
    <?php
        foreach($cities as $city) {
            echo "<option id='{$city->term_id}'>{$city->name}</option>";
        }
    ?>
</select>

<div id="dealers">
    <?php
        foreach( $dealers as $dealer ) {
            echo "<div city-id='{$dealer->city_id}' class='dealer'>
                <h3>{$dealer->post_title}</h3>
                <p>" . nl2br($dealer->post_content)  . "</p>
            </div>";
        }
    ?>
</div>