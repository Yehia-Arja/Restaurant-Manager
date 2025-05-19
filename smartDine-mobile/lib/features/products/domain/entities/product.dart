class Product {
  final int id;
  final String name;
  final String description;
  final String price;
  final String timeToDeliver;
  final String ingredients;
  final bool isFavorite;
  final String imageUrl;
  final String arModelUrl;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    required this.timeToDeliver,
    required this.ingredients,
    required this.isFavorite,
    required this.imageUrl,
    required this.arModelUrl,
  });
}
