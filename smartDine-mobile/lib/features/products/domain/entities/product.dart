class Product {
  final int id;
  final String name;
  final String description;
  final String price;
  final String timeToDeliver;
  final String ingredients;
  final bool isFavorited;
  final String imageUrl;
  final String arModelUrl;

  const Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    required this.timeToDeliver,
    required this.ingredients,
    required this.isFavorited,
    required this.imageUrl,
    required this.arModelUrl,
  });

  Product copyWith({
    int? id,
    String? name,
    String? description,
    String? price,
    String? timeToDeliver,
    String? ingredients,
    bool? isFavorited,
    String? imageUrl,
    String? arModelUrl,
  }) {
    return Product(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      price: price ?? this.price,
      timeToDeliver: timeToDeliver ?? this.timeToDeliver,
      ingredients: ingredients ?? this.ingredients,
      isFavorited: isFavorited ?? this.isFavorited,
      imageUrl: imageUrl ?? this.imageUrl,
      arModelUrl: arModelUrl ?? this.arModelUrl,
    );
  }
}
