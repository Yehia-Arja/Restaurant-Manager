import 'package:mobile/features/products/domain/entities/product.dart';

class ProductModel extends Product {
  ProductModel({
    required int id,
    required String name,
    required String description,
    required String price,
    required String timeToDeliver,
    required String ingredients,
    required String imageUrl,
    required String arModelUrl,
  }) : super(
         id: id,
         name: name,
         description: description,
         price: price,
         timeToDeliver: timeToDeliver,
         ingredients: ingredients,
         imageUrl: imageUrl,
         arModelUrl: arModelUrl,
       );

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] as int,
      name: json['name'] as String,
      description: json['description'] as String,
      price: json['price'] as String,
      timeToDeliver: json['time_to_deliver'] as String,
      ingredients: json['ingredients'] as String,
      imageUrl: json['image_url'] as String,
      arModelUrl: json['ar_model_url'] as String,
    );
  }

  Product toEntity() => this;
}
