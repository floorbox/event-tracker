![image](https://github.com/floorbox/event-tracker/assets/9636082/880603c4-1d23-4fc9-b18b-3ef213612ae2)


### Use like this

```

$metadata = request()->headers()->all();
$product = Product::first();

\EventTracker::attachMetadata($metadata)
      ->attachModel($product)
      ->send('product_visited');
