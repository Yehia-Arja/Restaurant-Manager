import 'package:flutter_bloc/flutter_bloc.dart';
import 'search_event.dart';
import 'search_state.dart';
import 'package:mobile/features/categories/domain/usecases/get_all_categories_usecase.dart';
import 'package:mobile/features/products/domain/usecases/get_products_usecase.dart';

class SearchBloc extends Bloc<SearchEvent, SearchState> {
  final GetAllCategoriesUseCase _catsUc;
  final GetProductsUseCase _prodsUc;

  SearchBloc(this._catsUc, this._prodsUc) : super(const SearchState()) {
    on<InitSearch>(_onInit);
    on<CategoryChanged>(_onCategoryChanged);
    on<QueryChanged>(_onQueryChanged);
    on<FetchMoreProducts>(_onFetchMore);
  }

  Future<void> _onInit(InitSearch e, Emitter<SearchState> emit) async {
    emit(state.copyWith(loadingCats: true, loadingProds: true, error: null));
    try {
      final cats = await _catsUc(); // no pagination
      final prods = await _prodsUc(page: 1);
      emit(
        state.copyWith(
          categories: cats,
          products: prods.items,
          hasMore: !prods.isLastPage,
          page: 1,
          loadingCats: false,
          loadingProds: false,
        ),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingCats: false, loadingProds: false));
    }
  }

  Future<void> _onCategoryChanged(CategoryChanged e, Emitter<SearchState> emit) async {
    emit(
      state.copyWith(
        selectedCategory: e.categoryId,
        products: [],
        page: 1,
        loadingProds: true,
        error: null,
      ),
    );
    try {
      final result = await _prodsUc(page: 1, categoryId: e.categoryId, query: state.query);
      emit(
        state.copyWith(products: result.items, hasMore: !result.isLastPage, loadingProds: false),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }

  Future<void> _onQueryChanged(QueryChanged e, Emitter<SearchState> emit) async {
    emit(state.copyWith(query: e.query, products: [], page: 1, loadingProds: true, error: null));
    try {
      final result = await _prodsUc(page: 1, categoryId: state.selectedCategory, query: e.query);
      emit(
        state.copyWith(products: result.items, hasMore: !result.isLastPage, loadingProds: false),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }

  Future<void> _onFetchMore(FetchMoreProducts e, Emitter<SearchState> emit) async {
    if (!state.hasMore || state.loadingProds) return;
    emit(state.copyWith(loadingProds: true, error: null));
    try {
      final next = state.page + 1;
      final result = await _prodsUc(
        page: next,
        categoryId: state.selectedCategory,
        query: state.query,
      );
      emit(
        state.copyWith(
          products: [...state.products, ...result.items],
          page: next,
          hasMore: !result.isLastPage,
          loadingProds: false,
        ),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }
}
