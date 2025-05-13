import 'package:flutter_bloc/flutter_bloc.dart';
import 'category_event.dart';
import 'category_state.dart';
import 'package:mobile/features/categories/domain/usecases/list_categories_usecase.dart';

class CategoryBloc extends Bloc<CategoryEvent, CategoryState> {
  final ListCategoriesUseCase _listUseCase;

  CategoryBloc(this._listUseCase) : super(CategoryInitial()) {
    on<LoadCategories>(_onLoadCategories);
  }

  Future<void> _onLoadCategories(LoadCategories event, Emitter<CategoryState> emit) async {
    emit(CategoryLoading());
    try {
      final categories = await _listUseCase.call(event.branchId);
      emit(CategoryLoaded(categories));
    } catch (e) {
      emit(CategoryError(e.toString()));
    }
  }
}
