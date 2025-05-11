class RestaurantModel {
  final int id;
  final String name;
  final String imageUrl;
  final String? description;

  RestaurantModel({required this.id, required this.name, required this.imageUrl, this.description});

  factory RestaurantModel.fromJson(Map<String, dynamic> json) {
    return RestaurantModel(
      id: json['id'] as int,
      name: json['name'] as String,
      imageUrl: json['image_url'] as String,
      description: json['description'] as String?,
    );
  }
}
