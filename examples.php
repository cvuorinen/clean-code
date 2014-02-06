<?php

## https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/EnvironmentDetector.php#L98

public function isMachine($name)
{
    return str_is($name, gethostname());
}

// Rewrite:

public function hostnameMatches($name)

public function isCurrentHost($hostname)



## https://github.com/drupal/drupal/blob/7.x/modules/block/block.module#L681

// Create an empty array if there are no entries.
if (!isset($blocks[$region])) {
    $blocks[$region] = array();
}
else {
    $blocks[$region] = _block_render_blocks($blocks[$region]);
}


// Rewrite:

$rendered_blocks = array();

if (isset($blocks[$region])) {
    $rendered_blocks = _block_render_blocks($blocks[$region]);
}



## https://github.com/drupal/drupal/blob/7.x/modules/block/block.module#L783

// Use the user's block visibility setting, if necessary.
if ($block->custom != BLOCK_CUSTOM_FIXED) {
    if ($user->uid && isset($user->data['block'][$block->module][$block->delta])) {
        $enabled = $user->data['block'][$block->module][$block->delta];
    }
    else {
        $enabled = ($block->custom == BLOCK_CUSTOM_ENABLED);
    }
}
else {
    $enabled = TRUE;
}


// Rewrite:

$enabled = TRUE;

if ($block->custom != BLOCK_CUSTOM_FIXED) {
    $enabled = ($block->custom == BLOCK_CUSTOM_ENABLED);

    if ($user->uid && isset($user->data['block'][$block->module][$block->delta])) {
        $enabled = $user->data['block'][$block->module][$block->delta];
    }
}


// Rewrite:

$enabled = TRUE;

if ($block->custom != BLOCK_CUSTOM_FIXED) {
    $enabled = ($block->custom == BLOCK_CUSTOM_ENABLED);
}

if ($block->custom != BLOCK_CUSTOM_FIXED && $user->uid
    && isset($user->data['block'][$block->module][$block->delta])
) {
    $enabled = $user->data['block'][$block->module][$block->delta];
}


## https://github.com/WordPress/WordPress/blob/master/wp-includes/class-wp.php#L298

// Limit publicly queried post_types to those that are publicly_queryable
if ( isset( $this->query_vars['post_type']) ) {
    $queryable_post_types = get_post_types( array('publicly_queryable' => true) );
    if ( ! is_array( $this->query_vars['post_type'] ) ) {
        if ( ! in_array( $this->query_vars['post_type'], $queryable_post_types ) )
            unset( $this->query_vars['post_type'] );
    } else {
        $this->query_vars['post_type'] = array_intersect( $this->query_vars['post_type'], $queryable_post_types );
    }
}


// Rewrite:
if (isset($this->query_vars['post_type'])) {
    $this->query_vars['post_type'] = $this->limitPubliclyQueriedPostTypes(
        $this->query_vars['post_type'],
        get_post_types( array('publicly_queryable' => true) )
    );
}

/**
 * Limit publicly queried post_types to those that are publicly_queryable
 * 
 * @param array|string $post_types           Current post types
 * @param array        $queryable_post_types Publicly queryable post types
 * 
 * @return array|string Post type(s) that are publicly queryable
 */
private function limitPublicPostTypes($post_types, array $queryable_post_types)
{
    if (is_array($post_types)) {
        return array_intersect($post_types, $queryable_post_types);
    }

    if (!in_array($post_types, $queryable_post_types)) {
        return;
    }

    return $post_types;
}


// Even more generic:

// Limit publicly queried post_types to those that are publicly_queryable
if (isset($this->query_vars['post_type'])) {
    $this->query_vars['post_type'] = $this->filterArrayOrString(
        $this->query_vars['post_type'],
        get_post_types( array('publicly_queryable' => true) )
    );
}


/**
 * Filter array or string to only those values that are allowed
 * 
 * @param array|string $values         String value or an array of values
 * @param array        $allowed_values Values that are allowed
 * 
 * @return array|string Value(s) that are allowed
 */
private function filterArrayOrString($values, array $allowed_values)
{
    if (is_array($values)) {
        return array_intersect($values, $allowed_values);
    }

    if (!in_array($values, $allowed_values)) {
        return;
    }

    return $values;
}
