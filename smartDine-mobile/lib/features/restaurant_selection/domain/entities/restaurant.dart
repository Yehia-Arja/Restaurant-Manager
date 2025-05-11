class Restaurant {
  final int id;
  final String name;
  final String imageUrl;
  final String? description;
  final bool isFavorite;

  Restaurant({
    required this.id,
    required this.name,
    required this.imageUrl,
    this.description,
    this.isFavorite = false,
  });
}
