import 'package:flutter/foundation.dart';

class RestaurantModel {
  final int id;
  final String name;
  final String imageUrl;
  final String? description;
  final bool isFavorite;

  RestaurantModel({
    required this.id,
    required this.name,
    required this.imageUrl,
    this.description,
    this.isFavorite = false,
  });

  factory RestaurantModel.fromJson(Map<String, dynamic> json) {
    return RestaurantModel(
      id: json['id'] as int,
      name: json['name'] as String,
      imageUrl: json['image_url'] as String,
      description: json['description'] as String?,
      isFavorite: json['is_favorite'] as bool? ?? false,
    );
  }
}
