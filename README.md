### Use like this

```

$metadata = request()->headers()->all();
$product = Product::first();

\EventTracker::attachMetadata($metadata)
      ->attachModel($product)
      ->send('product_visited');
