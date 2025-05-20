import 'package:flutter_bloc/flutter_bloc.dart';
import 'search_event.dart';
import 'search_state.dart';
import 'package:mobile/features/categories/domain/usecases/list_categories_usecase.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';
import 'package:mobile/features/favorite/domain/usecases/toggle_favorite_usecase.dart';

class SearchBloc extends Bloc<SearchEvent, SearchState> {
  final ListCategoriesUseCase _catsUc;
  final ListProductsUseCase _prodsUc;
  final ToggleFavoriteUseCase _toggleFavUc;

  SearchBloc(this._catsUc, this._prodsUc, this._toggleFavUc) : super(const SearchState()) {
    on<InitSearch>(_onInit);
    on<CategoryChanged>(_onCategoryChanged);
    on<QueryChanged>(_onQueryChanged);
    on<FetchMoreProducts>(_onFetchMore);
    on<ToggleSearchProductFavorite>(_onToggleFavorite);
  }

  Future<void> _onInit(InitSearch e, Emitter<SearchState> emit) async {
    emit(state.copyWith(loadingCats: true, loadingProds: true, error: null));
    try {
      final cats = await _catsUc(e.branchId);
      final prods = await _prodsUc(branchId: e.branchId, page: 1);
      emit(
        state.copyWith(
          branchId: e.branchId,
          categories: cats,
          products: prods.products,
          totalPages: prods.totalPages,
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
      final result = await _prodsUc(
        branchId: state.branchId!,
        page: 1,
        categoryId: e.categoryId,
        searchQuery: state.query,
        favoritesOnly: state.favoritesOnly,
      );
      emit(
        state.copyWith(
          products: result.products,
          totalPages: result.totalPages,
          loadingProds: false,
        ),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }

  Future<void> _onQueryChanged(QueryChanged e, Emitter<SearchState> emit) async {
    emit(
      state.copyWith(
        query: e.query,
        favoritesOnly: e.favoritesOnly,
        products: [],
        page: 1,
        loadingProds: true,
        error: null,
      ),
    );
    try {
      final result = await _prodsUc(
        branchId: state.branchId!,
        page: 1,
        categoryId: state.selectedCategory,
        searchQuery: e.query,
        favoritesOnly: e.favoritesOnly,
      );
      emit(
        state.copyWith(
          products: result.products,
          totalPages: result.totalPages,
          loadingProds: false,
        ),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }

  Future<void> _onFetchMore(FetchMoreProducts e, Emitter<SearchState> emit) async {
    if (state.loadingProds || state.page >= state.totalPages) return;

    emit(state.copyWith(loadingProds: true, error: null));
    try {
      final nextPage = state.page + 1;
      final result = await _prodsUc(
        branchId: state.branchId!,
        page: nextPage,
        categoryId: state.selectedCategory,
        searchQuery: state.query,
        favoritesOnly: state.favoritesOnly,
      );
      emit(
        state.copyWith(
          products: [...state.products, ...result.products],
          page: nextPage,
          totalPages: result.totalPages,
          loadingProds: false,
        ),
      );
    } catch (ex) {
      emit(state.copyWith(error: ex.toString(), loadingProds: false));
    }
  }

  Future<void> _onToggleFavorite(
    ToggleSearchProductFavorite event,
    Emitter<SearchState> emit,
  ) async {
    final idx = state.products.indexWhere((p) => p.id == event.productId);
    if (idx == -1) return;

    final original = state.products[idx];
    final toggled = original.copyWith(isFavorited: !original.isFavorited);
    final updatedList = List.of(state.products)..[idx] = toggled;

    emit(state.copyWith(products: updatedList));

    try {
      await _toggleFavUc(id: original.id, type: 'product');
    } catch (_) {
      updatedList[idx] = original;
      emit(state.copyWith(products: updatedList));
    }
  }
}
