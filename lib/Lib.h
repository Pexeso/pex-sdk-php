#ifdef __APPLE__
#define FFI_LIB "/usr/local/lib/libpexsdk.dylib"
#endif

#ifdef __linux__
#define FFI_LIB "/usr/local/lib/libpexsdk.so"
#endif

#include <stddef.h>

// ----------------------------------------------------------------------------
// Pex_Lock
// ----------------------------------------------------------------------------

void Pex_Lock();
void Pex_Unlock();

// ----------------------------------------------------------------------------
// Pex_Init
// ----------------------------------------------------------------------------

void Pex_Init(const char *client_id, const char *client_secret,
              int *status_code, char *status_message,
              size_t status_message_size);
void Pex_Cleanup();

// ----------------------------------------------------------------------------
// Pex_Status
// ----------------------------------------------------------------------------

typedef struct Pex_Status Pex_Status;

Pex_Status *Pex_Status_New();
void Pex_Status_Delete(Pex_Status **);
bool Pex_Status_OK(const Pex_Status *status);
int Pex_Status_GetCode(const Pex_Status *status);
const char *Pex_Status_GetMessage(const Pex_Status *status);

// ----------------------------------------------------------------------------
// Pex_Client
// ----------------------------------------------------------------------------

typedef struct Pex_Client Pex_Client;

typedef enum Pex_ClientType {
  Pex_PRIVATE_SEARCH = 0,
  Pex_PEX_SEARCH = 1,
} Pex_ClientType;

Pex_Client *Pex_Client_New();
void Pex_Client_Delete(Pex_Client **);

void Pex_Client_Init(Pex_Client *c, Pex_ClientType type, const char *client_id,
                     const char *client_secret, Pex_Status *s);

// ----------------------------------------------------------------------------
// Pex_Buffer
// ----------------------------------------------------------------------------

typedef struct Pex_Buffer Pex_Buffer;

Pex_Buffer *Pex_Buffer_New();
void Pex_Buffer_Delete(Pex_Buffer **);

void Pex_Buffer_Set(Pex_Buffer *b, const void *buf, size_t size);
const void *Pex_Buffer_GetData(const Pex_Buffer *b);
size_t Pex_Buffer_GetSize(const Pex_Buffer *b);

// ----------------------------------------------------------------------------
// Pex_Fingerprint
// ----------------------------------------------------------------------------

typedef enum Pex_Fingerprint_Type {
  Pex_Fingerprint_Type_Video = 1,
  Pex_Fingerprint_Type_Audio = 2,
  Pex_Fingerprint_Type_Melody = 4,
  Pex_Fingerprint_Type_All = Pex_Fingerprint_Type_Video |
                             Pex_Fingerprint_Type_Audio |
                             Pex_Fingerprint_Type_Melody
} Pex_Fingerprint_Type;

void Pex_Fingerprint_File(const char *file, Pex_Buffer *ft, Pex_Status *status,
                          int ft_types);
void Pex_Fingerprint_Buffer(const Pex_Buffer *buf, Pex_Buffer *ft,
                            Pex_Status *status, int ft_types);

// ----------------------------------------------------------------------------
// Pex_StartSearchRequest
// ----------------------------------------------------------------------------

typedef struct Pex_StartSearchRequest Pex_StartSearchRequest;

Pex_StartSearchRequest *Pex_StartSearchRequest_New();
void Pex_StartSearchRequest_Delete(Pex_StartSearchRequest **);

void Pex_StartSearchRequest_SetFingerprint(Pex_StartSearchRequest *rq,
                                           const Pex_Buffer *ft, Pex_Status *s);

// -----------------------------------------------------------------------------
// Pex_StartSearchResult
// -----------------------------------------------------------------------------

typedef struct Pex_StartSearchResult Pex_StartSearchResult;

Pex_StartSearchResult *Pex_StartSearchResult_New();
void Pex_StartSearchResult_Delete(Pex_StartSearchResult **);

bool Pex_StartSearchResult_NextLookupID(const Pex_StartSearchResult *rs,
                                        size_t *idx, char const **lookup_id);

// -----------------------------------------------------------------------------
// Pex_CheckSearchRequest
// -----------------------------------------------------------------------------

typedef struct Pex_CheckSearchRequest Pex_CheckSearchRequest;

Pex_CheckSearchRequest *Pex_CheckSearchRequest_New();
void Pex_CheckSearchRequest_Delete(Pex_CheckSearchRequest **);

void Pex_CheckSearchRequest_AddLookupID(Pex_CheckSearchRequest *rq,
                                        const char *lookup_id);

// -----------------------------------------------------------------------------
// Pex_CheckSearchResult
// -----------------------------------------------------------------------------

typedef struct Pex_CheckSearchResult Pex_CheckSearchResult;

Pex_CheckSearchResult *Pex_CheckSearchResult_New();
void Pex_CheckSearchResult_Delete(Pex_CheckSearchResult **);

const char *Pex_CheckSearchResult_GetJSON(const Pex_CheckSearchResult *rs);

// -----------------------------------------------------------------------------
// Search
// -----------------------------------------------------------------------------

void Pex_StartSearch(Pex_Client *c, const Pex_StartSearchRequest *rq,
                     Pex_StartSearchResult *rs, Pex_Status *s);
void Pex_CheckSearch(Pex_Client *c, const Pex_CheckSearchRequest *rq,
                     Pex_CheckSearchResult *rs, Pex_Status *s);
