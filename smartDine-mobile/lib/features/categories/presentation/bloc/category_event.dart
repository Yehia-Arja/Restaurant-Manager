import 'package:equatable/equatable.dart';

abstract class CategoryEvent extends Equatable {
  const CategoryEvent();

  @override
  List<Object?> get props => [];
}

class LoadCategories extends CategoryEvent {
  final int branchId;

  const LoadCategories(this.branchId);

  @override
  List<Object?> get props => [branchId];
}
