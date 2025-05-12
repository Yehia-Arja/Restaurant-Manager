import 'package:mobile/features/categories/domain/entities/category.dart';

class CategoryModel extends Category {
  CategoryModel({required int id, required String name, required String imageUrl})
    : super(id: id, name: name, imageUrl: imageUrl);

  factory CategoryModel.fromJson(Map<String, dynamic> json) {
    return CategoryModel(
      id: json['id'] as int,
      name: json['name'] as String,
      imageUrl: json['image_url'] as String,
    );
  }

  Category toEntity() => this;
}
