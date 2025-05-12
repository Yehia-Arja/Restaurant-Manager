import 'package:mobile/features/home/domain/entities/branch.dart';
import 'package:mobile/features/categories/domain/entities/category.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

class HomeData {
  final List<Branch> branches;
  final Branch selectedBranch;
  final List<Category> categories;
  final List<Product> products;

  HomeData({
    required this.branches,
    required this.selectedBranch,
    required this.categories,
    required this.products,
  });
}
