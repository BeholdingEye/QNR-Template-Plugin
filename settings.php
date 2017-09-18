<div class="wrap">
  <h1>QNR Template Plugin Settings</h1>
  <form method="post" action="options.php"> 
    <?php settings_fields('qnr_template_plugin-group'); ?>
    
    <h2 class="title">Section One</h2>
    <p>A few standard inputs for your plugin settings.</p>
    
    <table class="form-table">  
      <tr valign="top">
        <th scope="row">Setting A</th>
        <td><input type="text" name="qnr_template_settings_array[set_a]" id="qnr_template_settings_array_a" 
                                  value="<?php echo esc_attr(get_option('qnr_template_settings_array')['set_a']); ?>"></td>
      </tr>
      <!-- Email (text input though, for testing validation) -->
      <tr valign="top">
        <th scope="row">Setting B</th>
        <td><input type="text" name="qnr_template_settings_array[set_b]" id="qnr_template_settings_array_b" 
                                  value="<?php echo esc_attr(get_option('qnr_template_settings_array')['set_b']); ?>"></td>
      </tr>
      <!-- Checkbox -->
      <tr valign="top">
        <th scope="row">Setting C</th>
        <td><label><input type="checkbox" name="qnr_template_settings_array[set_c]" id="qnr_template_settings_array_c" 
                                value="1" <?php checked(1, get_option('qnr_template_settings_array')['set_c'], true); ?>> Setting C</label></td>
      </tr>
      <!-- Radios -->
      <tr valign="top">
        <th scope="row">Setting D</th>
        <td><label><input type="radio" name="qnr_template_settings_array[set_d]" id="qnr_template_settings_array_d_radio1" 
                                value="0" <?php checked(0, get_option('qnr_template_settings_array')['set_d'], true); ?>> Setting Da</label><br><br>
            <label><input type="radio" name="qnr_template_settings_array[set_d]" id="qnr_template_settings_array_d_radio2" 
                                value="1" <?php checked(1, get_option('qnr_template_settings_array')['set_d'], true); ?>> Setting Db</label></td>
      </tr>
      <!-- Select/Options menu -->
      <tr valign="top">
        <th scope="row">Setting E</th>
        <td>
        <select name="qnr_template_settings_array[set_e]">
          <option value="0" <?php selected(0, get_option('qnr_template_settings_array')['set_e'], true); ?>>Option Zero</option>
          <option value="1" <?php selected(1, get_option('qnr_template_settings_array')['set_e'], true); ?>>Option One</option>
          <option value="2" <?php selected(2, get_option('qnr_template_settings_array')['set_e'], true); ?>>Option Two</option>
          <option value="3" <?php selected(3, get_option('qnr_template_settings_array')['set_e'], true); ?>>Option Three</option>
        </select>
        </td>
      </tr>
    </table>
        
    <h2 class="title">Section Two</h2>
    <p>Create as many sections as required.</p>

    <?php submit_button(); ?>
  </form>
</div>