import 'package:mobile/features/home/domain/entities/home_data.dart';
import 'branch_model.dart';
import 'package:mobile/features/categories/data/models/category_model.dart';
import 'package:mobile/features/products/data/models/product_model.dart';

class HomeDataModel {
  final List<BranchModel> branches;
  final BranchModel selectedBranch;
  final List<CategoryModel> categories;
  final List<ProductModel> products;

  HomeDataModel({
    required this.branches,
    required this.selectedBranch,
    required this.categories,
    required this.products,
  });

  factory HomeDataModel.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>;

    final branchesJson = data['branches'] as List<dynamic>;
    final branches =
        branchesJson.map((e) => BranchModel.fromJson(e as Map<String, dynamic>)).toList();

    final selected = BranchModel.fromJson((data['selected_branch'] as Map<String, dynamic>));

    final catsJson = data['categories'] as List<dynamic>;
    final categories =
        catsJson.map((e) => CategoryModel.fromJson(e as Map<String, dynamic>)).toList();

    final prodsJson = data['products'] as List<dynamic>;
    final products =
        prodsJson.map((e) => ProductModel.fromJson(e as Map<String, dynamic>)).toList();

    return HomeDataModel(
      branches: branches,
      selectedBranch: selected,
      categories: categories,
      products: products,
    );
  }

  HomeData toEntity() => HomeData(
    branches: branches,
    selectedBranch: selectedBranch,
    categories: categories,
    products: products,
  );
}
