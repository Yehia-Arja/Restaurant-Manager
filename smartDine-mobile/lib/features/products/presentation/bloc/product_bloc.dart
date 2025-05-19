import 'package:flutter_bloc/flutter_bloc.dart';
import 'product_event.dart';
import 'product_state.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';
import 'package:mobile/features/favorite/domain/usecases/toggle_favorite_usecase.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

class ProductBloc extends Bloc<ProductEvent, ProductState> {
  final ListProductsUseCase _listUseCase;
  final ToggleFavoriteUseCase _toggleFavoriteUseCase;
  bool _isFetching = false;

  ProductBloc(this._listUseCase, this._toggleFavoriteUseCase) : super(ProductInitial()) {
    on<LoadProducts>(_onLoadProducts);
    on<ToggleProductFavorite>(_onToggleFavorite);
  }

  Future<void> _onLoadProducts(LoadProducts event, Emitter<ProductState> emit) async {
    if (_isFetching) return;
    _isFetching = true;

    try {
      final isFirstPage = event.page == 1;

      if (isFirstPage) {
        emit(ProductLoading());
      } else if (state is ProductLoaded) {
        final current = state as ProductLoaded;
        emit(
          ProductLoaded(
            products: current.products,
            currentPage: current.currentPage,
            totalPages: current.totalPages,
            isFetchingMore: true,
          ),
        );
      }

      final result = await _listUseCase.call(
        branchId: event.branchId,
        searchQuery: event.searchQuery,
        categoryId: event.categoryId,
        favoritesOnly: event.favoritesOnly,
        page: event.page,
      );

      final newProducts = result.products;
      final totalPages = result.totalPages;

      if (state is ProductLoaded && !isFirstPage) {
        final previous = state as ProductLoaded;
        emit(
          ProductLoaded(
            products: [...previous.products, ...newProducts],
            currentPage: event.page,
            totalPages: totalPages,
          ),
        );
      } else {
        emit(ProductLoaded(products: newProducts, currentPage: event.page, totalPages: totalPages));
      }
    } catch (e) {
      emit(ProductError(e.toString()));
    } finally {
      _isFetching = false;
    }
  }

  Future<void> _onToggleFavorite(ToggleProductFavorite event, Emitter<ProductState> emit) async {
    if (state is! ProductLoaded) return;
    final current = state as ProductLoaded;

    final idx = current.products.indexWhere((p) => p.id == event.productId);
    if (idx < 0) return;

    final original = current.products[idx];
    final toggled = Product(
      id: original.id,
      name: original.name,
      description: original.description,
      price: original.price,
      timeToDeliver: original.timeToDeliver,
      ingredients: original.ingredients,
      isFavorited: !original.isFavorited,
      imageUrl: original.imageUrl,
      arModelUrl: original.arModelUrl,
    );

    final updatedList = List<Product>.from(current.products)..[idx] = toggled;

    emit(
      ProductLoaded(
        products: updatedList,
        currentPage: current.currentPage,
        totalPages: current.totalPages,
        isFetchingMore: current.isFetchingMore,
      ),
    );

    try {
      await _toggleFavoriteUseCase(id: original.id, type: 'product');
    } catch (_) {
      updatedList[idx] = original;
      emit(
        ProductLoaded(
          products: updatedList,
          currentPage: current.currentPage,
          totalPages: current.totalPages,
          isFetchingMore: current.isFetchingMore,
        ),
      );
    }
  }
}
