export const Card = ({ children, className = "" }) => (
    <div className={`bg-white rounded-xl p-4 shadow ${className}`}>
      {children}
    </div>
  );
  
  export const CardContent = ({ children, className = "" }) => (
    <div className={className}>{children}</div>
  );
  